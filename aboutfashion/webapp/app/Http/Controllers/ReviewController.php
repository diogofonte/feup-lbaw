<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    } 


    public function listByUser($id_user){
        //lista de reviews de um user
        //verificar nome da view
        return view('reviews.list_by_user', 
        ['reviews' => Review::where('id_user', $id_user)->get()]);
    }

    /**
     * Display a listing of the reviews of a specific product
     *
     * @param int $id_product
     */
    public function listByProduct($id_product){
        //lista de reviews de um user
        //verificar nome da view
        return view('reviews.list_by_product',
        ['reviews' => Review::where('id_product', $id_product)->get()]);
    }


    public function create(Request $request){
        $user = Auth::user();
        $products = array();
        foreach($user->orders->where('status','Completed') as $order){
            foreach($order->details as $detail){
                if(count($detail->product->reviews->where('id_user', $user->id)) == 0){
                    array_push($products, $detail->product);
                }
            }
        }
        return view('pages.reviews.create', compact('products'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=> 'required|string|max:30',
            'description' => 'required|string|max:100',
            'evaluation' => 'required|integer|min:0|max:5',
            'id_product' => 'required|integer',
        ]);
        
        if($validator->fails()){
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }

        if(!$product = Product::find($request->input('id_product'))){
            return redirect()->back();
        };

        
        $review = new Review;
        
        $this->authorize('createReview', $product);
        
        $review->id_user = Auth::user()->id;
        $review->id_product = $request->input('id_product');
        $review->date = date('Y-m-d H:i:s');
        $review->evaluation = $request->input('evaluation');
        $review->description = $request->input('description');
        $review->title = $request->input('title');
        
        if($review->save()){
            return Redirect::route('userView', array('id'=>Auth::user()));
        }else{
            return redirect()->back();
        }
    }

    public function show($id){
        if(!$review = Review::find($id)){
            abort('404');
        };
        $this->authorize('show', $review);
        return view('reviews.show',[ 'review' => $review]);
    }

    public function edit($id){
        $review = Review::find($id);
        if(is_null($review)){
            return abort('404');
        }
        $this->authorize('update', $review);
        return view('pages.reviews.edit', ['review' => $review]);    
    }


    public function update(Request $request, $id){
        $review = Review::find($id);
        $this->authorize('update', $review);

        $validator = Validator::make($request->all(),[
            'title'=> 'required|string|max:30',
            'description' => 'required|string|max:100',
            'evaluation' => 'required|integer',
        ]);
        
        if($validator->fails()){
            return Redirect::back()->withErrors(array('error'=>'error'));
        }

        $review['evaluation'] = $request->input('evaluation');
        $review['title'] = $request->input('title');
        $review['description'] = $request->input('description');
        if ($review->save()) {
            return Redirect::route('userView', array('id'=>Auth::user()));
        }else{
            return Redirect::back()->withErrors(array('error'=>'error'));
        }
    }

    public function destroy($id){
        if (!$review = Review::find($id)) {
            abort('404');
        };
        
        $this->authorize('delete', $review);

        if($review->delete()){
            return Redirect::route('userView', array('id'=>Auth::user()));
        }else{
            return Redirect::back()->withErrors(array('error'=>'error'));
        } 
    }

    public function delete($id){
        if(!is_numeric($id)){
            return Response::json(array('status' => 'error', 'message'=>'Bad request!'),400);
        }

        $this->authorize('updateReview', Auth::guard('admin')->user());
        $review = Review::find($id);
        if(is_null($review)){
            return Response::json(array('status' => 'error', 'message' => 'Review not found!'), 404);
        }

        if($review->delete()){
            return Response::json(array('status' => 'success', 'message'=>'OK!'),200);
        }else{
            return Response::json(array('status' => 'error', 'message'=>'Something happens!'),500);
        }
    }
}