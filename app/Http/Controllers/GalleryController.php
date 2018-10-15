<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function Index(){
        $images = Image::where('url', 'like', '%thumbnail%')->get();

        return view('gallery.index', ['images' => $images]);
    }
}
