<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model{
    public $timestamps = false;

    protected $table = 'stock';
    //protected $primaryKey = ['id_product', 'id_size', 'id_color'];

 
    public function product(){
        return $this->belongsTo('App\Models\Product', 'id_product');
    }

    public function size(){
        return $this->belongsTo('App\Models\Size', 'id_size');
    }

    public function color(){
        return $this->belongsTo('App\Models\Color', 'id_color');
    }
}