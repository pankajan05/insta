<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(\App\Post $post){
        return view('post.show',compact('post'));
    }

    public function create(){
        return view('post.create');
    }

    public function store(){
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required','image'] ,
        ]);

        $imagePath = request('image')->store('uploads','public');
        $image = Image::make(public_path("storage/{$imagePath}"))->resize(1200,1200);
        $image->save();
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect('/profile/'.auth()->user()->id);
    }
}
