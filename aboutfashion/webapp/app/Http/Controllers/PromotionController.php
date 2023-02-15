<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller{
    
    public function create(Request $request){
        $this->authorize('updatePromotion', Auth::guard('admin')->user());
        $products = Product::all();
        return view('pages.admin.addPromotion', array('products' => $products));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'discount' => 'required|numeric',
            'start_date' => 'required|date',
            'final_date' => 'required|date',
        ]);
        
        if($validator->fails()){
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }

        $promotion = new Promotion();
        
        $this->authorize('createPromotion', Auth::guard('admin')->user());
        
        $promotion->discount = $request->input('discount');
        $promotion->start_date = $request->input('start_date');
        $promotion->final_date = $request->input('final_date');
        
        if($promotion->save()){
            return Redirect::route('promotionsAdminPanel');
        }else{
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }
    }

    public function edit(Request $request){
        $this->authorize('updatePromotion', Auth::guard('admin')->user());
        $promotion = Promotion::find($request->id);
        $products = Product::all();
        return view('pages.admin.editPromotion', ['promotion'=>$promotion, 'products' => $products]);
    }

    public function update(Request $request, $id){
        if(!$promotion = Promotion::find($id)){
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }
        $this->authorize('updatePromotion', Auth::guard('admin')->user());

        $validator = Validator::make($request->all(),[
            'discount' => 'required|numeric',
            'start_date' => 'required|date',
            'final_date' => 'required|date',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }

        $promotion->discount = $request->input('discount');
        $promotion->start_date = $request->input('start_date');
        $promotion->final_date = $request->input('final_date');

        if ($promotion->save()) {
            return Redirect::route('promotionsAdminPanel');
        } else {
            return Redirect::back()->withErrors(array('status' => 'error', 'message'=>'Error!'));
        }
    }

    public function delete($id){
        if(!is_numeric($id)){
            return Response::json(array('status' => 'error', 'message'=>'Bad request!'),400);
        }

        $this->authorize('updatePromotion', Auth::guard('admin')->user());
        $promotion = Promotion::find($id);
        if(is_null($promotion)){
            return Response::json(array('status' => 'error', 'message' => 'Promotion not found!'), 404);
        }

        if($promotion->delete()){
            return Response::json(array('status' => 'success', 'message'=>'OK!'),200);
        }else{
            return Response::json(array('status' => 'error', 'message'=>'Something happens!'),500);
        }
    }
}