<?php

namespace App\Http\Controllers;

use App\Notifications\ProductWishlistAvailable;
use Exception;
use App\Models\Size;
use App\Models\User;
use App\Models\Color;
use App\Models\Image;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ChangePriceWishlist;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ChangePriceShoppingCart;

class ProductController extends Controller{
    
    public function addProductImage(Request $request, $id_product){
        $product = Product::find($id_product);
            if(is_null($product)){
                return abort('404');
        }
        $file = $request->file('image');
        $imageId = (new ImageController)->store($file);
        $product->images()->attach($imageId);
        $product->save();

        return Redirect::route('editProduct', ['id' => $product->id]);
    }

    public function deleteProductImage($id_image, $id_product){
        $product = Product::find($id_product);
        $imageModel = Image::find($id_image);

        if(is_null($product) || is_null($imageModel)){
            return abort('404');
        }

        $product->images()->detach($imageModel->id);
        $product->save();
        Storage::delete('public/'.$imageModel->file);
        $imageModel->delete();

        return Redirect::route('editProduct', ['id' => $product->id]);
    }

    public function editProductImage(Request $request, $id_image, $id_product){
        $product = Product::find($id_product);
        $imageModel = Image::find($id_image);
        $oldImagePath = $imageModel->file;
        if(is_null($product) || is_null($imageModel)){
            return abort('404');
        }

        $imageDir = 'public/img/';
        $newImage = $request->file('image');
        $newImgName = date('mdYHis') . uniqid() . '.' . $newImage->extension();
        $newImage->storeAs($imageDir, $newImgName);

        $imageModel->file = 'img/'. $newImgName;
        $imageModel->save();

        Storage::delete('public/'.$oldImagePath);

        return Redirect::route('editProduct', ['id' => $product->id]);
    }

    public function create(Request $request){
        $this->authorize('updateProduct', Auth::guard('admin')->user());
        $categories = Category::all();
        return view('pages.admin.addProduct', array('categories' => $categories));
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'id_category' => 'required|integer',
            'name'=> 'required|string|max:30',
            'description' => 'nullable|string|max:100',
            'price' => 'required|numeric',
            'images' => 'array|required',
            'images.*' => 'required|mimetypes:image/jpg,image/jpeg,image/bmp,image/png',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors(array('error'=>'error'));
        }
        
        if(!$category = Category::find($request->input('id_category'))){
            return Redirect::back()->withErrors(array('error'=>'error'));
        };

        $product = new Product();
        
        $this->authorize('createProduct', Auth::guard('admin')->user());
    
        $product->id_category = $request->input('id_category');
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->save();

        if($files=$request->file('images')){
            foreach($files as $file){
                $imageId = (new ImageController)->store($file);
                $product->images()->attach($imageId);
            }
        }
        
        if($product->save()){
            return Redirect::route('productsAdminPanel');
        }else{
            return Redirect::back()->withErrors(array('error'=>'error'));
        }
    }

    public function edit(Request $request){
        $this->authorize('updateProduct', Auth::guard('admin')->user());
        $product = Product::find($request->id);
        $categories = Category::all();
        $promotions = Promotion::all();
        $colors = Color::all();
        $sizes = Size::all(); 
        return view('pages.admin.editProduct', ['product'=>$product, 
                                                'categories' => $categories, 
                                                'promotions' => $promotions,
                                                'colors' => $colors,
                                            'sizes' => $sizes]);
    }

    public function update(Request $request){
        $id = $request['id'];
        if(!$product = Product::find($id)){
            return Redirect::back()->withErrors(array('error'=>'error'));
        }
        $oldPrice = $product->price;
        $this->authorize('updateProduct', Auth::guard('admin')->user());

        $validator = Validator::make($request->all(),[
            'id_category' => 'required|integer',
            'name'=> 'required|string|max:30',
            'description' => 'nullable|string|max:100',
            'price' => 'required|numeric',
        ]);



        $product['name'] = $request->input('name');
        $product['description'] = $request->input('description');
        $product['price'] = $request->input('price');
        $product['id_category'] = $request->input('id_category');


        if ($product->save()) {
            if($product->price != $oldPrice){
                $usersShopping = array();
                $usersWishlist = array();
                foreach(User::all() as $user)
                {
                    if($user->wishlist->contains($product)){
                        array_push($usersWishlist, $user);
                    }
                    try{
                        if(count($user->orders->where('status', 'Shopping Cart')->first()->details->where('id_product', $product->id)) != 0){
                            array_push($usersShopping, $user);
                        }
                    }catch(Exception $e){
                        
                    }
                }
                Notification::send($usersWishlist, new ChangePriceWishlist($product));
                Notification::send($usersShopping, new ChangePriceShoppingCart($product));
            }
            return Redirect::route('productsAdminPanel');
        } else {
            return Redirect::back()->withErrors(array('error'=>'error'));
        }
    }

    public function delete($id){
        if(!is_numeric($id)){
            return Response::json(array('status' => 'error', 'message'=>'Error!'),400);
        }

        $this->authorize('updateProduct', Auth::guard('admin')->user());
        $product = Product::find($id);
        if(is_null($product)){
            return Response::json(array('status' => 'error', 'message' => 'Product not found!'), 404);
        }

        if($product->delete()){
            return Response::json(array('status' => 'success', 'message'=>'OK!'),200);
        }else{
            return Response::json(array('status' => 'error', 'message'=>'Something happens!'),500);
        }
    }

    public function addNewProductStock(Request $request, $id){
        if(!$product = Product::find($id)){
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }

        if(!(Auth::guard('admin')->user()->role == 'Collaborator')){
            abort(403);
        }

        $validator = Validator::make($request->all(),[
            'id_color' => 'required|integer',
            'id_size' => 'required|integer',
            'new_stock' => 'required|integer',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }

        $id_color = $request->input('id_color');
        $id_size = $request->input('id_size');

        if(is_null(Stock::where('id_size', $id_size)->where('id_color', $id_color)->where('id_product', $id)->first())){
            
            if (DB::insert('insert into stock (stock, id_product, id_color, id_size) values (?, ?, ?, ?)', [$request->input('new_stock'),$id,$id_color,$id_size ])){
                $users = array();
                $product = Product::find($id);
                $stockN = Stock::where('id_size', $id_size)->where('id_color', $id_color)->where('id_product', $id)->first();
                foreach(User::all() as $user)
                {
                    if($user->wishlist->contains($product)){
                        array_push($users, $user);
                    }
                }
                Notification::send($users, new ProductWishlistAvailable($product, $stockN));
                return Redirect::route('productsAdminPanel');
            } else {
                return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
            }

        } else {
            return redirect()->back();
        }
    }

    public function modifyProductStock(Request $request, $id){
        if(!$product = Product::find($id)){
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }

        if(!(Auth::guard('admin')->user()->role == 'Collaborator')){
            abort(403);
        }

        $validator = Validator::make($request->all(),[
            'id_color' => 'required|integer',
            'id_size' => 'required|integer',
            'new_stock' => 'required|integer',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }

        $id_color = $request->input('id_color');
        $id_size = $request->input('id_size');

        if(!$stock = Stock::where('id_size', $id_size)->where('id_color', $id_color)->where('id_product', $id)->first()){
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Stock not found!'));
        }

        if (DB::update('UPDATE stock SET stock = ? WHERE id_product = ? AND id_color = ? AND id_size = ?', array($request->input('new_stock'),$id,$id_color,$id_size ))) {
                if($stock->stock < $request->input('new_stock')){
                    $users = array();
                    $product = Product::find($id);
                    $stockN = Stock::where('id_size', $id_size)->where('id_color', $id_color)->where('id_product', $id)->first();
                foreach(User::all() as $user)
                {
                    if($user->wishlist->contains($product)){
                        array_push($users, $user);
                    }
                }
                Notification::send($users, new ProductWishlistAvailable($product, $stockN));    
                }
                
            return Redirect::route('productsAdminPanel');
        } else {
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }
    }


    public function addProductPromotion(Request $request, $id){
        if(!$product = Product::find($id)){
            return Redirect::back()->withErrors(array('error'=>'error'));
        }

        if(!(Auth::guard('admin')->user()->role == 'Collaborator')){
            abort(403);
        }

        $validator = Validator::make($request->all(),[
            'id_promotion' => 'required|integer',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }

        if (!$promotion = Promotion::find($request->input('id_promotion'))){
            return Redirect::back()->withErrors(array('error'=>'error'));
        }
       
        $product->promotions()->attach($promotion); 

        if ($product->save()) {
            return Redirect::route('productsAdminPanel');
        } else {
            return Redirect::back()->withErrors(array('error'=>'error'));
        }
    }

    public function removeProductPromotion(Request $request, $id){
        if(!$product = Product::find($id)){
            return Redirect::back()->withErrors(array('error'=>'error'));
        }

        if(!(Auth::guard('admin')->user()->role == 'Collaborator')){
            abort(403);
        }

        $validator = Validator::make($request->all(),[
            'id_promotion' => 'required|integer',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors(array('error'=>'error'));
        }

        if (!$promotion = Promotion::find($request->input('id_promotion'))){
            return Redirect::back()->withErrors(array('error'=>'error'));
        }
       
        $product->promotions()->detach($promotion); 

        if ($product->save()) {
            return Redirect::route('productsAdminPanel');
        } else {
            return Redirect::back()->withErrors(array('error'=>'error'));
        }
    }

    public function show($id){
        $product = Product::findOrFail($id);
        $user = Auth::user(); 
        if(isset($user)){
            if(count($user->wishlist()->where('id_product', $id)->get()) != 0){
                return view('pages.products.show',['product' => $product, 'wishlist'=>true]);
            }else{
                return view('pages.products.show',['product' => $product, 'wishlist'=>false]);
            }
        }
        return view('pages.products.show',[ 'product' => $product]);
    }

    public function searchAPI(Request $request){        
       $validator = Validator::make($request->all(),[
           'id_product' => 'nullable|integer',
           'id_category' => 'nullable|integer',
           'id_size' => 'nullable|integer',
           'id_color' => 'nullable|string',
           'min_price' => 'nullable|numeric',
           'max_price' => 'nullable|numeric',
           'min_classification' => 'nullable|numeric',
           'product_name' => 'nullable|string',
           'order' => 'nullable|string'
        ]);

        if($validator->fails()){
            return Response()->json(['status'=>'BAD REQUEST', 'msg'=>'Some or all arguments entered are not correct'],400);
        }
        

        $filters = array();
        if(!is_null($request['id_product'])){
            array_push($filters, array('id','=',$request['id_product']));
        }
        if(!is_null($request['id_category'])){
            array_push($filters, array('id_category','=',$request['id_category']));
        }
        if(!is_null($request['min_price'])){
            array_push($filters, array('price','>=',$request['min_price']));
        }
        if(!is_null($request['max_price'])){
            array_push($filters, array('price','<=',$request['max_price']));
        }if(!is_null($request['min_classification'])){
            array_push($filters, array('avg_classification','<=',$request['min_classification']));
        } 
        $query = Product::where($filters);
        if(!is_null($request['product_name'])){
            $query->search($request['product_name']);
        }
        if(!is_null($request['id_size'])){
            $query->whereRelation('stocks', 'id_size', $request['id_size']);
        }
        if(!is_null($request['id_color'])){
            $query->whereRelation('stocks', 'id_color', $request['id_color']);
        }
       
        if($request['order'] == 'price_asc'){
            $products = $query->orderBy('price', 'ASC')->get();
        }else if($request['order'] == 'price_desc'){
            $products = $query->orderBy('price', 'DESC')->get();
        }else if($request['order'] == 'avg_desc'){
            $products = $query->orderBy('avg_classification', 'DESC')->get();
        }else if($request['order'] == 'name_asc'){
            $products = $query->orderBy('name', 'ASC')->get();
        }else if($request['order'] == 'name_desc'){
            $products = $query->orderBy('name', 'DESC')->get();
        }
        else{
            $products = $query->get();
        }

        $productsJSON = array();

        foreach($products as $product){
            $evaluation = Product::find($product['id'])->reviews()->avg('evaluation');
            
            $imageDB = Product::find($product['id'])->images()->get();
            $images = array();
            foreach($imageDB as $image){
                $images[] = $image['file'];
            }

            $categoryDB = Product::find($product['id'])->category()->get();
            $category = array("id" => $categoryDB[0]['id'], "name" => $categoryDB[0]['name']);
                
            $localTime = date('Y-m-d H:i:s');
            $promotions = Product::find($product['id'])->promotions()->where('start_date','<=',$localTime)->where('final_date','>=',$localTime)->orderBy('discount', 'DESC')->get();
            $promotion = array();
            if(count($promotions) != 0){
                $promotion = array("id"=>$promotions[0]['id'],"discount"=>$promotions[0]['discount'],"start_date"=>$promotions[0]['start_date'], "final_date"=>$promotions[0]['final_date']);
            }

            $productsJSON[] = array("id"=> $product['id'], "name"=>$product['name'], "description"=>$product['description'], "price"=>$product['price'], "avg_classification"=> $evaluation, "images"=>$images, "category"=>$category, "promotion"=>$promotion);
        } 

        return json_encode($productsJSON);
    }

    public function showSearchPage(){
        $categories = Category::all();
        $sizes = Size::all();
        $colors = Color::all();
        $user = Auth::user(); 
        if(is_null($user)){
            return view('pages.searchProduct',['order'=>null, 'categories'=>$categories, 'sizes'=>$sizes, 'colors'=>$colors]);   
        }
        return view('pages.searchProduct',[ 'categories'=>$categories, 'sizes'=>$sizes, 'colors'=>$colors, 'order' => $user->orders->where('status', 'Shopping Cart')->first()]);
    }
}