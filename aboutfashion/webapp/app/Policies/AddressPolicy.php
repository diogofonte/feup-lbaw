<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy{
    use HandlesAuthorization;

    public function show(User $user, Address $address){
        return $user->id == $address->id_user;
    }

    public function list(User $user, $addresses){
        foreach($addresses as $address){
            if($address->id_user != $user->id){
                return false;
            }
        }
        return true;
    } 


    public function update(User $user, Address $address){
        return $user->id == $address->id_user;
    }


    public function delete(User $user, Address $address){
        return $user->id == $address->id_user;
    } 

    public function checkout(User $user, Address $address){
        return $user->id == $address->id_user;
    }
}