<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{
    public $timestamps = false;

    protected $table = 'category';


    public function superCategory(){
        return $this->belongsTo('App\Models\Category', 'id_super_category');
    }

    public function subCategories(){
        return $this->hasMany('App\Models\Category', 'id_super_category');
    }

    public function products(){
        return $this->hasMany('App\Models\Product');
    }

    public function getAllSubCategories(){
        $categories = array();
        $unexploredCategories = array();
        $id = $this->id;

        do{
            $categoriesDB = Category::findOrFail($id)->subCategories;
            if(count($categoriesDB) != 0){
                foreach($categoriesDB as $category){
                    array_push($unexploredCategories,$category['id']);
                    array_push($categories, $category);
                }   
            }
            
            if(count($unexploredCategories) == 0){
                break;
            }else{
                $id = $unexploredCategories[0];
                array_splice($unexploredCategories, 0, 1);
            }
            
        }while(true);    
        return $categories;
    }

    public function getAllSuperCategories(){
        $categories = array();
        $superCategory = $this->superCategory;
        while(!is_null($superCategory)){
            array_push($categories, $superCategory);
            $superCategory = $superCategory->superCategory;
        }
        
        return $categories;
    }
}