<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Mail\NewUserWelcomeMail;

Route::get('/email',function (){
    return new NewUserWelcomeMail();
});

Auth::routes();


Route::post('/follow/{user}','FollowsController@store');

Route::get('/', 'PostsController@index');



Route::get('/p/create','PostsController@create');
Route::get('/p/{post}','PostsController@show');
Route::post('/p','PostsController@store');

Route::get('/home/{user}','profilecontroller@index')->name('profile.show');
Route::get('/profile/{user}', 'profilecontroller@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'profilecontroller@edit')->name('profile.show');
Route::patch('/profile/{user}', 'profilecontroller@update')->name('profile.update');
