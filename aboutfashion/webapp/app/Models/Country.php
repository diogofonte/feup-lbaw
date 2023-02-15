<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps  = false;
    protected $table = 'country';

    public function addresses(){
        return $this->hasMany('App\Models\Address', 'id_address');
    }
}