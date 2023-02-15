<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    
    public $timestamps  = false;
    protected $table = 'card';

    public function user(){
        return $this->belongsTo('App\Models\User', 'id_user');
    }

}