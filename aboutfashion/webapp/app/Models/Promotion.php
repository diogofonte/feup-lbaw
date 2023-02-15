<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model{
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    protected $table = 'promotion';

    public function products(){
        return $this->belongsToMany('App\Models\Product', 'promotion_product', 'id_promotion', 'id_product');
    }
}