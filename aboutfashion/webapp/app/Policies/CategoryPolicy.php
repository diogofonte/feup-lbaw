<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy{
    use HandlesAuthorization;
}