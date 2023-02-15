<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Detail;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class ShoppingCartController extends Controller{

    public function show(Request $request){
        if(!Auth::check()){
            $details = array();
            $cart = $request->session()->get('cart');
            if(is_null($cart)){
                return view('pages.user.shopping_cart', array('guestCart'=>null, 'order'=>null));
            }
            foreach($cart as $productCart){
                $product = Product::find($productCart['id_product']);
                $color = Color::find($productCart['id_color']);
                $size = Size::find($productCart['id_size']);
                array_push($details, array('id' => $productCart['id'],'product' => $product, 'color' => $color, 'size' => $size, 'quantity' => $productCart['quantity']));
            }
            return view('pages.user.shopping_cart', array('guestCart'=>$details, 'order'=>null));
        } else {
            return view('pages.user.shopping_cart', array('order' => Auth::user()->orders->where('status', 'Shopping Cart')->first(), 'guestCart' => null));
        }
    }

    private function checkCombination(int $id_product, int $id_color, int $id_size){
        return count(Stock::where('id_product', $id_product)->where('id_size', $id_size)->where('id_color', $id_color)->get()) != 0;
    }

    private function searchArray(int $id_product, int $id_color, int $id_size, array $cart){
        $keys = array_keys($cart);
        foreach($keys as $key){
            if($cart[$key]['id_product'] == $id_product && $cart[$key]['id_color'] == $id_color && $cart[$key]['id_size'] == $id_size){
                return $key;
            }  
        }
        return -1;
    }


    private function createShoppingCart(int $id_user){
        $shoppingCart = Order::where('id_user',$id_user)->where('status', 'Shopping Cart')->first();
        if(is_null($shoppingCart)){
            $shoppingCart = new Order();
            $shoppingCart->id_user = $id_user;
            $shoppingCart->date = date('Y-m-d H:i:s');
            $shoppingCart->save();
        }
        return $shoppingCart;
    }

    private function createDetail(int $id_order, int $id_product, int $id_color, int $id_size){
        $filters = array(['id_order',$id_order], ['id_product',$id_product], ['id_size',$id_size], ['id_color', $id_color]);
        $detail = Detail::where($filters)->first();
        if(is_null($detail)){
            $detail = new Detail();
            $detail->id_order = $id_order;
            $detail->id_product = $id_product;
            $detail->id_color = $id_color;
            $detail->id_size = $id_size;
            $detail->quantity = 0;
            $detail->save();
        }
        return $detail;
    }

    public function addProductAuth(int $id_product, int $id_color, int $id_size, int $quantity){
        $id_user = Auth::user()->id;
        $shoppingCart = $this->createShoppingCart($id_user);
        $detail = $this->createDetail($shoppingCart->id, $id_product,$id_color,$id_size);
        if(is_null($detail)){
            return null;
        }
        $detail->quantity += $quantity;
        if ($detail->save()) {
            return $detail;
        }
        return null;
    }

    private function getDetailJSON(int $id_detail){
        if(Auth::user()){
            $detail = Detail::find($id_detail);
            $product = $detail->product;
            $color = $detail->color->name;
            $size = $detail->size->name;
            $quantity = $detail->quantity;
        }else{
            $productCart = Session::get('cart')[$id_detail];
            $product = Product::find($productCart['id_product']);
            $color = Color::find($productCart['id_color'])->name;
            $size = Size::find($productCart['id_size'])->name;
            $quantity = $productCart['quantity'];
        }
        
        $productName = $product->name;
        $productImage = $product->images[0]->file;
        $priceWithPromotion = $product->getPriceWithPromotion(date('Y-m-d H:i:s'));
        $priceWithoutPromotion = $product->price;
        
        return array('name' => $productName, 'image' => $productImage, 'price_with_promotion' => $priceWithPromotion, 'price_without_promotion' => $priceWithoutPromotion, 'quantity' => $quantity, 'color' => $color, 'size' => $size);
        
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
           'id_color' => 'required|integer',
           'id_size' => 'required|integer',
           'id_product' => 'required|integer'
        ]);

        if($validator->fails()){
            return Response::json(array('status'=>'error','message'=>'Bad request!'),400);
        }

        if(Auth::user()){
            $detail = $this->addProductAuth($request['id_product'], $request['id_color'], $request['id_size'], 1);
            if(!is_null($detail)){
                return Response::json(array('status'=>'success','message' => 'The product has been added from your cart!', 'product'=>$this->getDetailJSON($detail->id), 'id_detail'=>$detail),200);
            }else{
                return Response::json(array('status'=>'error','message' => 'An error occurred and we were unable to add the product to your cart!'),500);
            }
        }
        else{
            if(!$this->checkCombination($request['id_product'], $request['id_color'], $request['id_size'])){
                return Response::json(array('status' => 'error', 'message => The product, color and size combination you want does not exist!'), 404);
            }
            if($cart = $request->session()->get('cart')){
                $i = $this->searchArray($request['id_product'], $request['id_color'], $request['id_size'], $cart);
                if($i == -1){
                    $i = end($cart)['id'] + 1;
                    array_push($cart, array('id' => $i, 'id_product' => $request['id_product'], 'id_color' => $request['id_color'], 'id_size' => $request['id_size'], 'quantity' => 1));
                }else{
                    $cart[$i]['quantity']++;
                }
            }else{
                $i = 0;
                $cart = array();
                array_push($cart, array('id' => $i, 'id_product' => $request['id_product'], 'id_color' => $request['id_color'], 'id_size' => $request['id_size'], 'quantity' => 1));
            }            
            $request->session()->put('cart', $cart);
            
            return Response::json(array('status' => 'success', 'message' => 'The product has been added from your cart!', 'product' =>  $this->getDetailJSON($i), 'id_detail'=>$i), 200);
        }

    }

    public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'id_detail' => 'integer|required',
         ]);

        if($validator->fails()){
            return Response::json(array('status'=>'error','message'=>'Bad request!'),400);
        }

        if(Auth::check()){
            $detail = Detail::find($request['id_detail']);
            if(is_null($detail)){
                return Response::json(array('status' => 'error', 'message' => 'Product detail not found!'), 404);
            }
        
            $this->authorize('delete', $detail);
            if($detail->delete()){
                return Response::json(array('status'=>'success','message' => 'The product has been deleted from your cart!'),200);
            }else{
                return Response::json(array('status'=>'error','message' => 'An error occurred and we were unable to delete the product from your cart!'),500);
            }
        }else{
            if(!$cart = $request->session()->get('cart')){
                return Response::json(array('status' => 'error', 'message' => "Don't have a shopping cart"), 404);
            }
            if(isset($cart[$request['id_detail']])){
                unset($cart[$request['id_detail']]);
                $request->session()->put('cart', $cart);
                return Response::json(array('status' => 'success', 'message' => 'The product has been deleted from your cart!'), 200);
            }else{
                return Response::json(array('status' => 'error', 'message' => "There is no such product in the shopping cart"), 404);
            }
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id_detail' => 'required|integer',
            'quantity' => 'required|integer|min:1',
         ]);

        if($validator->fails()){
            return Response::json(array('status'=>'error','message'=>'Bad request!'),400);
        }

        if(Auth::check()){
            $detail = Detail::find($request['id_detail']);
            if(is_null($detail)){
                return Response::json(array('status' => 'error', 'message' => 'Product detail not found!'), 404);
            }
            $this->authorize('update', $detail);
        
            $detail->quantity = $request['quantity'];
            if($detail->save()){
                return Response::json(array('status'=>'success','message' => 'The quantity has changed'),200);
            }else{
                return Response::json(array('status'=>'error','message' => 'An error occurred and we were unable to change the quantity', 'quantity'=>$detail->quantity),500);
            }            

        }else{
            if(!$cart = $request->session()->get('cart')){
                return Response::json(array('status' => 'error', 'message' => "Don't have a shopping cart"), 404);
            }
            if(isset($cart[$request['id_detail']])){
                $cart[$request['id_detail']]['quantity'] = $request['quantity'];
                $request->session()->put('cart', $cart);
                return Response::json(array('status' => 'success', 'message' => 'The quantity has been updated!'), 200);
            }else{
                return Response::json(array('status' => 'error', 'message' => "You do not have this combination product, color and size in your shopping cart!"), 404);
            }
        }
    }
}