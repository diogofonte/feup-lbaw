<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\User;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Order;
use App\Models\Review;
use App\Models\Report;
use App\Models\Category;

use Illuminate\Http\Request;

class AdminPanelController extends Controller{

    public function __construct(){
        $this->middleware('auth:admin');
    }

    public function homePageAdmin(){
        return view('pages.admin.home');
    }

    //Users

    public function usersPageAdmin(){
        $users = User::orderBy('id', 'ASC')->paginate(15);
        return view('pages.admin.users', ['users'=>$users]);
    }

    public function userPurchaseHistoryPageAdmin($id){
        $user = User::find($id);
        if(is_null($user)){
            return abort('404');
        }
        return view('pages.admin.userPurchaseHistory', ['user'=>$user]);
    }

    //Products

    public function productsPageAdmin(){
        $products = Product::orderBy('id', 'ASC')->paginate(15);
        return view('pages.admin.products', ['products'=>$products]);
    }
    //add and edit product is in ProductController

    // Categories - present in Products Page
     public function categoriesPageAdmin(){
        $categories = Category::orderBy('id', 'ASC')->paginate(15);
        return view('pages.admin.categories', ['categories'=>$categories]);
    }

    // Promotions

    public function promotionsPageAdmin(){
        $promotions = Promotion::orderBy('id', 'ASC')->paginate(15);
        return view('pages.admin.promotions', ['promotions'=>$promotions]);
    }
    //add and edit promotion is in PromotionController

    // Orders

    public function ordersPageAdmin(){
        $orders = Order::orderBy('id', 'ASC')->paginate(15);
        return view('pages.admin.orders', ['orders'=>$orders]);
    }
    //add and edit order is in OrderController

    // Reviews

    public function reviewsPageAdmin(){
        $reviews = Review::orderBy('id', 'ASC')->paginate(15);
        return view('pages.admin.reviews', ['reviews'=>$reviews]);
    }

    // Reports

    public function reportsPageAdmin(){
        $reports = Report::orderBy('id', 'ASC')->paginate(15);
        return view('pages.admin.reports', ['reports'=>$reports]);
    }
}