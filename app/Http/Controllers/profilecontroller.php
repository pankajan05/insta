<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class profilecontroller extends Controller
{
    public function index($user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user) : false;
        $user = User::findOrFail($user);

        $postcount = Cache::remember(
            'count.posts.'. $user->id,
            now()->addSecond(3) ,
            function() use ($user){
            return $user->posts->count();
        });
        $followers = Cache::remember(
            'count.followers.'. $user->id,
            now()->addSecond(3) ,
            function() use ($user){
                return $user->profile->followers->count();
            });
        $followings = Cache::remember(
            'count.followings.'. $user->id,
            now()->addSecond(3) ,
            function() use ($user){
                return $user->following->count();
            });




        return view('profile.index',compact('user', 'follows', 'postcount', 'followers', 'followings'));
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

            $imageArray = ['image' => $imagePath];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []

        ));

        return redirect("/profile/{$user->id}");
    }
}
