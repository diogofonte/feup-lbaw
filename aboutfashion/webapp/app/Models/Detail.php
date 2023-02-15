<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    public $timestamps = false;
    protected $table = 'details';

    public function product(){
        return $this->belongsTo('\App\Models\Product','id_product');
    }

    public function color(){
        return $this->belongsTo('\App\Models\Color','id_color');
    }

    public function size(){
        return $this->belongsTo('\App\Models\Size','id_size');
    }

    public function order(){
        return $this->belongsTo('\App\Models\Order', 'id_order');
    }
}