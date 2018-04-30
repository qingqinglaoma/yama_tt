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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::get('/getprofile', 'ProfileController@getProfile');
Route::get('/editprofile', 'ProfileController@editProfile');
Route::post('/editprofile/{user_id}', 'ProfileController@editProfilePost');
Route::get('/uploadpicture', 'ProfileController@uploadPicture');
Route::post('/uploadpicture/{user_id}', 'ProfileController@uploadPicturePost');

