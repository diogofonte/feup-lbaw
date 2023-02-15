<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps  = false;
    protected $table = 'address';

    public function user(){
        return $this->belongsTo('\App\Models\User', 'id_user');
    }

    public function country(){
        return $this->belongsTo('\App\Models\Country', 'id_user');
    }
}