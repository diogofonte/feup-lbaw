<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    public $timestamps = false;

    protected $table = 'review';

    public function reports(){
        return $this->hasMany('App\Models\Report','id_report');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function like(){
        return $this->belongsToMany('App\Models\User', 'user_like', 'id_review', 'id_user');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product', 'id_product');
    }
    
}