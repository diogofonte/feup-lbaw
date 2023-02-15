<?php

namespace App\Policies;

use App\Models\Card;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CardPolicy
{
    use HandlesAuthorization;


    public function show(User $user, Card $card)
    {
        return $user->id = $card->id_user;
    }

    public function list(User $user, $cards){
        foreach($cards as $card){
            if($card->id != $user->id){
                return false;
            }
        }
        return true;
    } 


    public function update(User $user, Card $card)
    {
        return $user->id == $card->id_user;
    }


    public function delete(User $user, Card $card)
    {
        return $user->id == $card->id_user;
    } 

    public function checkout(User $user, Card $card){
        return $user->id == $card->id_user;
    }
}