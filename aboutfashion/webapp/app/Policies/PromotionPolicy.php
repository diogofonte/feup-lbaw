<?php

namespace App\Policies;

use App\Models\Promotion;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy{
    use HandlesAuthorization;
}