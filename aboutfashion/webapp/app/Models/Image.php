<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps  = false;
    protected $table = 'image';

    public function admins(){
        return $this->hasMany('App\Models\Admin', 'id_image');
    }

    public function users(){
        return $this->hasMany('App\Models\User', 'id_image');
    }

    public function products(){
        return $this->belongsToMany('App\Models\Product', 'product_image', 'id_image', 'id_product');
    }

    public function imageURL(){
        $file = $this->file;
        if (strpos($file,"http") !== false){
            $profileImg = $file;
        } else {
            $profileImg = 'storage/'.$file;
        }
        return $profileImg;
    }
}