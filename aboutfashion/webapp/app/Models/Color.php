<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model{
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    protected $table = 'color';

    public function stock(){
        return $this->hasMany('App\Models\Stock', 'id_color');
    }

    public function details(){
        return $this->hasMany('App\Models\Detail', 'id_color');
    }

    public function products(){
        return $this->belongsToMany('App\Models\Product', 'stock', 'id_color', 'id_product');
    }
}