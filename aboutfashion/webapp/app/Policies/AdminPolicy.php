<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy{
    use HandlesAuthorization;

    public function view(Admin $admin, Admin $model){
        return $admin->id == $model->id;
    }

    public function updateUser(Admin $admin){
        return $admin->role == 'Technician';
    }

    public function updateProduct(Admin $admin){
        return $admin->role == 'Collaborator';
    }

    public function createProduct(Admin $admin){
        return $admin->role == 'Collaborator';
    }

    public function updateCategory(Admin $admin){
        return $admin->role == 'Collaborator';
    }

    public function createCategory(Admin $admin){
        return $admin->role == 'Collaborator';
    }

    public function updatePromotion(Admin $admin){
        return $admin->role == 'Collaborator';
    }

    public function createPromotion(Admin $admin){
        return $admin->role == 'Collaborator';
    }

    public function updateOrder(Admin $admin){
        return $admin->role == 'Collaborator';
    }

    public function updateReview(Admin $admin){
        return $admin->role == 'Technician';
    }

    public function updateReport(Admin $admin){
        return $admin->role == 'Technician';
    }
}