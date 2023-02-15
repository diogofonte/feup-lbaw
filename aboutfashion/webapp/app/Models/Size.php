<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model{
    public $timestamps = false;

    protected $table = 'size';

    public function stocks(){
        return $this->hasMany('App\Models\Stock', 'id_size');
    }

    public function details(){
        return $this->hasMany('App\Models\Detail', 'id_size');
    }

    public function products(){
        return $this->belongsToMany('App\Models\Product', 'stock', 'id_size', 'id_product');
    }
}