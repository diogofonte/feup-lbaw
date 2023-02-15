<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller{

    public function __construct(){
        $this->middleware('auth:web');
    }

    public function index(){
        return view('users.index', ['users' => User::all()]);
    }

    public function show($id){
        
        $user = User::find($id);
        if(is_null($user)){
            return abort('404');
        }
        $this->authorize('view', $user);
        return view('pages.user.show',[ 'user' => $user, 'countries'=>Country::all()]);
        
    }

    public function edit($id){
        $user = User::find($id);
        if(is_null($user)){
            return abort('404');
        }
        $this->authorize('update', $user);
        return view('pages.user.edit', ['user' => $user]);

    }

    public function update(Request $request, $id){
        $user = User::find($id);
        if(is_null($user)){
            return abort('404');
        }
        $this->authorize('update', $user);
        
        $validator = Validator::make($request->all(),[
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:authenticated_user,email',
            'password' => 'nullable|string|min:6|confirmed',
            'birth_date' => 'nullable|date',
            'gender' => 'string|regex:/^[PBMFO]$/',
        ]);

        if($validator->fails()){
            return redirect()->back(); // Adicionar as mensagens de erro
        }
 
        
        if(!is_null($request['first_name'])){
            $user->first_name = $request['first_name'];
        }
        if(!is_null($request['last_name'])){
            $user->last_name = $request['last_name'];
        }
        if(!is_null($request['email'])){
            $user->email = $request['email'];
        }
        if(!is_null($request['password'])){
            $user->password = bcrypt($request['password']);
        }
        if(!is_null($request['birth_date'])){
            $user->birth_date = $request['birth_date'];
        }
        if($request['gender'] == 'B'){
            $user->gender = null;
        }else if($request['gender'] == 'P'){
        }else{
            $user->gender = $request['gender'];
        }
        
        $user->save();
        return Redirect::route('userView', array('id' => $user->id));
    }

    public function delete(Request $request, int $id){
        $user = User::find($request['id']);
        if(is_null($user)){
            return abort('404');
        }

        $this->authorize('delete', $user);
        $deleted = $user->delete();
        if($deleted)
            return redirect('/');
        else
            return redirect()->back(); // Adicionar mensagens de erro
    }

    public function editPicture(Request $request, $id){
        $user = User::find($id);
        if(is_null($user)){
            return abort('404');
        }
        $imageDir = 'public/img/';
        $image = $request->file('image');
        $imgName = date('mdYHis') . uniqid() . '.' . $image->extension();
        $image->storeAs($imageDir, $imgName);
        $imageModel = new Image;
        $imageModel->file = 'img/'. $imgName;
        $imageModel->save();

        //$imageId = (new ImageController)->store($request);
        //$request['id'] = $user->photo['id'];
        //(new ImageController)->delete($request);

        $oldImg = $user->photo;
        if ($oldImg['id'] !== 3329){
            Storage::delete('public/'.$oldImg['file']);
            $oldImg->delete();
        }
        $user->id_image = $imageModel->id;
        $user->save();
        return Redirect::route('userView', array('id' => $user->id));
    }

    public function deletePicture($id){
        $user = User::find($id);
        if(is_null($user)){
            return abort('404');
        }
        $oldImg = $user->photo;
        if ($oldImg['id'] !== 3329){
            Storage::delete('public/'.$oldImg['file']);
            $oldImg->delete();
        }
        $user->id_image = 3329;
        $user->save();
        return Redirect::route('userView', array('id' => $user->id));
    }

    public function toggleProductWishlist(Request $request){
        $validator = Validator::make($request->all(),[
            'id_product' => 'required|int',
        ]); 

        if($validator->fails()){
            return Response::json(array('status' => 'error', 'message'=>'Bad request!'),400);
        }

        if(!$product = Product::find($request['id_product'])){
            return Response::json(array('status' => 'error', 'message'=>'Product not found!'),404);
        }

        $user = Auth::user();
        if($user->wishlist()->where('id_product',$product->id)->exists()){
            $user->wishlist()->detach($product);
        }else{
            $user->wishlist()->attach($product);
        }
        return Response::json(array('status' => 'success', 'message'=>'OK!'),200);
        
    }

    public function showWishlist(){
        $user = Auth::user();
        if(is_null($wishlist = $user->wishlist)){
            return view('pages.wishlist', array('wishlist' => null));
        }else{
            return view('pages.wishlist', array('wishlist' => $wishlist));
        }
    } 
    public function showNotifications(){
        $user = Auth::user();
        $notifications = array();
        foreach($user->notifications as $notification){
            array_push($notifications, array('id' => $notification->id, 'title' => $notification->data['title'], 'description' => $notification->data['text'], 'date' => $notification->created_at));
        }
        return view('pages.user.notifications', array('notifications'=>$notifications));
    } 
}