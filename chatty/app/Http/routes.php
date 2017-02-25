<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/***
*HomeController
*/
Route::get('/',[
    'uses' => '\Chatty\Http\Controllers\HomeController@index',
    'as' => 'home',
]);

Route::get('/alert',function(){
    return redirect()->route('home')->with('info','You have signed up!');
});

/***
*Authentication
*/
/*Signup Routes*/
Route::get('/signup',[
    'uses'=>'\Chatty\Http\Controllers\AuthController@getSignup',
    'as'=>'auth.signup',
    'middleware'=>['guest'],
]);

Route::post('/signup',[
    'uses'=>'\Chatty\Http\Controllers\AuthController@postSignup',
    'middleware'=>['guest'],
]);

/*Signin Routes*/
Route::get('/signin',[
    'uses'=>'\Chatty\Http\Controllers\AuthController@getSignin',
    'as'=>'auth.signin',
    'middleware'=>['guest'],
]);

Route::post('/signin',[
    'uses'=>'\Chatty\Http\Controllers\AuthController@postSignin',
]);

/*Sign Out*/
Route::get('/signout',[
    'uses'=>'\Chatty\Http\Controllers\AuthController@getSignout',
    'as'=>'auth.signout',
]);


/***
*Search
*/

Route::get ('/search',[
    'uses'=>'\Chatty\Http\Controllers\SearchController@getResults',
    'as'=>'search.results',
]);

/**
*Profile
*/
//index profile(index method)
Route::get('/user/{username}',[
    'uses'=>'\Chatty\Http\Controllers\ProfileController@getProfile',
    'as'=>'profile.index',
]);

//update profile(edit method)

Route::get('/profile/edit',[
    'uses'=>'\Chatty\Http\Controllers\ProfileController@getEdit',
    'as'=>'profile.edit',
    'middleware'=>['auth'],//middleware'=>['auth'] will allow only signed users to make changes
]);

Route::post('/profile/edit',[
    'uses'=>'\Chatty\Http\Controllers\ProfileController@postEdit',
    'middleware'=>['auth'],//middleware'=>['auth'] will allow only signed users to make changes
]);