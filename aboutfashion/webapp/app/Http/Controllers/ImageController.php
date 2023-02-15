<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function test(){
        return view('pages.uploadImage');
        //return view('pages.editImage');
        //return view('pages.deleteImage');
    }

    public function store($file)
    {
        $imageDir = 'public/img/';
        $imgName = date('mdYHis') . uniqid() . '.' . $file->extension();
        $file->storeAs($imageDir, $imgName);
        $imageModel = new Image;
        $imageModel->file = 'img/'. $imgName;
        $imageModel->save();
        return $imageModel->id;
    }

    public function edit(Request $request){
        $image = $request->file('image');
        $imageID = $request->id;
        $imageModel = Image::find($imageID);
        if(is_null($imageModel)){
          return abort('404');
        }
        Storage::delete($imageModel->file);
        $imagePath = Storage::putFile('images', $image);
        $imageModel->file = $imagePath;
        if($imageModel->save()){
            return $imageID;
        }else{
            return -1;
        }
    }

    public function delete(Request $request){
        $imageID = $request->id;
        $imageModel = Image::find($imageID);
        if(is_null($imageModel)){
          return abort('404');
        }
        Storage::delete($imageModel->file);
        $imageModel->delete();
        return $imageID;
    }
    
}