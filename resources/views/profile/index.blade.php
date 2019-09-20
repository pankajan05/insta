@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3  p-5">
            <img src="{{ $user->profile->profileImage() }}" class="rounded-circle" height="100px">
        </div>
        <div class="col-9">
            <div class="d-flex justify-content-between align-items-baseline"><h2>{{$user->username}}</h2>
                @can('update',$user->profile)
                <a href="/p/create">Add New Post</a>
                @endcan
            </div>

            @can('update',$user->profile)
            <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">
                <div class="pr-4"><strong>{{ $user->posts->count() }}</strong>posts</div>
                <div class="pr-4"><strong>43k</strong>follwers</div>
                <div class="pr-4"><strong>34</strong>following</div>
            </div>
            <div class="font-weight-bold pt-2">{{ $user->profile->title }}</div>
            <div style="width: 70%;">{{ $user->profile->description }}</div>
            <div><a href="£">{{ $user->profile->url }}</a> </div>
        </div>
    </div>


    <div class="row pt-5">
       @foreach($user->posts as $post)
           <div class="col-4 pb-4">
               <a href="/p/{{ $post->id }}">
                <img src="/storage/{{ $post->image }}" class="w-100">
               </a>
           </div>

    @endforeach
    </div>
</div>
@endsection