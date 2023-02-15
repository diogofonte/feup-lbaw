<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy {
    use HandlesAuthorization;

    public function updatePromotions(Admin $admin){
        return $admin->role == 'Collaborator';
    }

    public function createReview(User $user, Product $product)
    {
    return true;
        if($user->blocked){
            return false;
        }

        if(Review::where('id_user', $user->id)->where('id_product', $product->id)->count() >= 1){
            return false;
          };

        if ($user->orders->where('status', 'Completed')->details->where('id_product', $product->id)->count() == 0) {
            return false;
        }
    
        foreach($user->orders->where('status', 'Completed') as $order){
          if(count($order->details->where('id_product', $product->id)) != 0){
            return true;
          }
        }
    
          return false;    
    }
}