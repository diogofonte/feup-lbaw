<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'report';

    public function user(){
        return $this->belongsTo('App\Models\User', 'id_user');
    }

    public function review(){
        return $this->belongsTo('App\Models\Report','id_review');
    }
}
