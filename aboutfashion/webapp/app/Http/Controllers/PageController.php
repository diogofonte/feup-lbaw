<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Order;
use App\Models\Review;
use App\Models\Report;

use Illuminate\Support\Facades\Auth;

class PageController extends Controller{

    public function homePage(){
        $promotions = Promotion::all();
        return view('pages.home',['promotions'=>$promotions]);
    }


    public function homePageAdmin(){
        $users = User::all();
        return view('pages.admin.home', ['users'=>$users]);
    }

    public function aboutPage(){
        $user = Auth::user(); 
        if(is_null($user)){
            return view('pages.about',['order'=>null]);   
        }
        return view('pages.about',[ 'order' => $user->orders->where('status', 'Shopping Cart')->first()]);
    }

    public function helpPage(){
        $user = Auth::user(); 
        if(is_null($user)){
            return view('pages.help',['order'=>null]);   
        }
        return view('pages.help',[ 'order' => $user->orders->where('status', 'Shopping Cart')->first()]);
    }

    public function contactsPage(){
        $user = Auth::user(); 
        if(is_null($user)){
            return view('pages.contacts',['order'=>null]);   
        }
        return view('pages.contacts',[ 'order' => $user->orders->where('status', 'Shopping Cart')->first()]);
    } 
}