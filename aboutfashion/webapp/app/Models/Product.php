<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{ 
    // Don't add create and update timestamps in database.
    public $timestamps = false;

    protected $table = 'product';


    public function category(){
        return $this->belongsTo('App\Models\Category', 'id_category');
    }

    public function images(){
        return $this->belongsToMany('\App\Models\Image', 'product_image', 'id_product', 'id_image');
    }

    public function wishlist(){
        return $this->belongsToMany('\App\Models\User', 'wishlist', 'id_product', 'id_user');
    }

    public function reviews(){
        return $this->hasMany('\App\Models\Review', 'id_product');
    }
    
    public function promotions(){
        return $this->belongsToMany('\App\Models\Promotion', 'promotion_product', 'id_product', 'id_promotion');
    }

    public function stocks(){
        return $this->hasMany('\App\Models\Stock', 'id_product');
    }

    public function sizes(){
        return $this->belongsToMany('App\Models\Size', 'stock', 'id_product', 'id_size');
    }
    
    public function colors(){
        return $this->belongsToMany('App\Models\Color', 'stock', 'id_product', 'id_color');
    }

    public function details(){
        return $this->hasMany('App\Models\Detail','stock', 'id_product');
    }

    public function getPriceWithPromotion(string $date){
        $filter = array(['start_date','<=',$date], ['final_date','>=',$date]);
        $promotion = $this->promotions()->where($filter)->orderBy('discount', 'DESC')->first();
        $discount = is_null($promotion) ? 0 : $promotion->discount;
        return round($this->price * (1 - $discount / 100),2);
    }

    public function getPromotion(string $date){
        $filter = array(['start_date','<=',$date], ['final_date','>=',$date]);
        $promotion = $this->promotions()->where($filter)->orderBy('discount', 'DESC')->first();
        return $promotion;
    }

    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }
        return $query->whereRaw('tsvectors @@ plainto_tsquery(\'english\', ?)', [$search])->orderByRaw('ts_rank(tsvectors, plainto_tsquery(\'english\', ?)) DESC', [$search]);
    }
}