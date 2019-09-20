<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class profilecontroller extends Controller
{
    public function index($user)
    {
       $user = User::findOrFail($user);
        return view('profile.index',[
            'user' => $user,]);
    }

    public function edit(User $user){
        $this->authorize('update',$user->profile);
        return view('profile.edit',compact('user'));
    }

    public function update(User $user){
        $this->authorize('update',$user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        if(request('image')){
            $imagePath = request('image')->store('profile','public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(1000,1000);
            $image->save();
        }

        auth()->user()->profile->update(array_merge(
            $data,
            ['image' => $imagePath]
        ));

        return redirect("/profile/{$user->id}");
    }
}
