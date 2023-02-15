<?php

namespace App\Policies;

use App\Models\Detail;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetailPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Detail $detail)
    {
        return $user->id == $detail->order->id_user;
    }


    public function delete(User $user, Detail $detail)
    {
        return $user->id == $detail->order->id_user;
    }

}