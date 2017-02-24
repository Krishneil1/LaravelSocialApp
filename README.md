## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)


# LaravelSocialApp
This is a tutorial app for project I am working on.

##Brief Notes

###Adding HomeController and Base Template
After installing Laravel 5.1. I did some housekeeping. Remove unnecessary file. Followed by adding a HomeController which extend the base controller. 
```
namespace Chatty\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view ('home');
    }
}
```
Next I added a route 'index'. 
```
Route::get('/',[
    'uses' => '\Chatty\Http\Controllers\HomeController@index',
    'as' => 'home',
]);
```
In the views folder add a view as home.blade.php. Laravel uses blade templating. This can be as simple as writing home.  However in this case it is as follows.
```
@extends('templates.default')

@section('content')
    <h3>Welcome to Chatty</h3>
    <p>The best social network, like..ever.</p>
@stop
```
I also created two folders templates and one sub folder partials. Inside partial create a file default.blade.php 

```
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset ="UTF=8">
        <title> Chatty </title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        @include('templates.partials.navigation')
        <div class ="container">
            @yield ('content')
    </body>
</html>
```
This has a default outline and reference to bootstrap  
Inside partials create a file. naviagtion.blade.php
```
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Chatty</a>
    </div>
    <div class="collapse navbar-collapse">

        <ul class="nav navbar-nav">
            <li><a href="#">Timeline</a></li>
            <li><a href="#">Friends</a></li>
        </ul>
        <form class="navbar-form navbar-left" role="search" action="#">
            <div class ="form-group">
                <input type ="text" name="query" class="form-control" placeholder ="Find People">
            </div>
            <button class="btn btn-success" type="submit">Search</button>
        </form>

        <ul class="nav navbar-nav navbar-right">

            <li><a href ="#">Dayle</a></li>
            <li><a href="#">Update profile</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </ul>
    </div>
  </div>
</nav>
```
###Alert Message

This will provide simple alerts for example when the use signs up our social net work.
create a new file inside partials and name id alerts.blade.php.
```
@if(Session::has('info'))
    <div class="alert alert-info" role="alert">
    {{Session::get('info')}}
    </div>
@endif
```
Add the following code in you default page 
```
@include('templates.partials.alerts')
```
For simple test you can place the following route
```
Route::get('/alert',function(){
    return redirect()->route('home')->with('info','You have signed up!');
});
``` 
Refresh the page http://localhost:8000/alert and how you should see you alert message 
```
You have signed up!
```
###User Table Creation/Migrations
Creating user table.
Navigate to .env file and edit as per your Database Design

```
APP_ENV=local
APP_DEBUG=true
APP_KEY=ruA9CAKRJCFgLOD1nc5o1BmvaTGokasi

DB_HOST=localhost
DB_DATABASE=chatty
DB_USERNAME=
DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```
 On your command terminal enter the following:
```
php artisan make:migration create_users_table
```
This will create you users table migrations. 
```
public function up()
    {
        Schema::create ('users',function(Blueprint $table){
            $table->increments('id');
            $table->string('email');
            $table->string('username');
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('location')->nullable();
            $table->string('remember_token')->nullable();
            $table->timestampe();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down()
    {
        //
        Schema::drop('users');
    }
      
```
Next using the following command create your users table
```
php artisan migrate
```
 If you are using MySQL. Few changes to do if you get the following error;
```
[PDOException]
  SQLSTATE[HY000] [1044] Access denied for user ''@'localhost' to database 'chatty'
```
Inside your config-> database.php file change the following section to be able to connect to the database.
```

        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', 'chatty'),
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

```
You also need to change the .env file
```
DB_HOST=localhost
DB_DATABASE=chatty

```
###Signing Up

First, we will create a new Auth controller. app->Http->Controllers create a new file AuthController.php
```
namespace Chatty\Http\Controllers;
use Illuminate\Http\Request; 

class AuthController extends Controller
{
    public function getSignup()
    {
        //get request that displays the page
        return view('auth.signup');
    }
    public function postSignup(Request $request)
    {
        //post the data through this
    }
}
```
use Illuminate\Http\Request; is built in Laravel to use $request.
 creatte a new folder inside resources->views->auth and create a new file signup.blade.php.

Next, add the route to this. Head to Http->routes.php and add the following code
```
Route::get('/signup',[
    'uses'=>'\Chatty\Http\Controllers\AuthController@getSignup',
    'as'=>'auth.signup',
]);

Route::post('/signup',[
    'uses'=>'\Chatty\Http\Controllers\AuthController@postSignup',
]);
```
Next add a signup form. create new folder auth in views and add file signup.blade.php
```
@extends('templates.default')

@section('content')
    <form class="form-vertical" role="form" method ="post" action="{{route('auth.signup')}}">
        <div class="form-group{{$errors->has('email')? ' has-error': ''}}">
            <label for="email" class="control-label">Your Email Address:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email"name="email" value="{{Request::old('email')?:''}}">
            @if($errors->has('email'))
                <span class="help-block">{{$errors->first('email')}}</span>
            @endif
        </div>
        <div class="form-group{{$errors->has('username')? ' has-error': ''}}">
            <label for="username" class="control-label">Choose a Username</label>
            <input type="text" class="form-control" id="username" placeholder="Enter Username"name="username" value="{{Request::old('username')?:''}}">
            @if($errors->has('username'))
                <span class="help-block">{{$errors->first('username')}}</span>
            @endif
        </div>
        <div class="form-group{{$errors->has('password')? ' has-error': ''}}">
            <label for="pwd">Choose a Password:</label>
            <input type="password" class="form-control" id="password" name ="password" placeholder="Enter password">
            @if($errors->has('password'))
                <span class="help-block">{{$errors->first('password')}}</span>
            @endif
        </div>
        <div class="checkbox">
            <label><input type="checkbox"> Remember me</label>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </div>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
  </form>
@stop
```
Modify the authController 
```
<?php

namespace Chatty\Http\Controllers;
use Illuminate\Http\Request;
Use Chatty \Models\User;

class AuthController extends Controller
{
    public function getSignup()
    {
        //get request that displays the page
        return view('auth.signup');
    }
    public function postSignup(Request $request)
    {
        //post the data through this
        $this->validate($request,[
            'email'=>'required|unique:users|email|max:255',
            'username'=>'required|unique:users|alpha_dash|max:20',
            'password'=>'required|min:6',
        ]);
        
        User::create([
            'email'=>$request->input('email'),
            'username'=>$request->input('username'),
            'password'=>bcrypt($request->input('password')),
        ]);

        return redirect()
            ->route('home')
            ->with('info','Your account has been created and you can now sign in');
    }
}
```
####Model

We are going to create a model inside app folder and delete the existing User.php model. Create a folder Models inside app

```

<?php

namespace Chatty\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
        'email', 
        'password',
        'first_name',
        'last_name',
        'location',
        ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token'];
}

```
You should now be able to sign up. At this timeline, we have covered the basic MVC. Model(E.g. User.php) , View(E.g.  Signup.blade.php) , Controller( E.g. AuthController) . However, Laravel goes a step further than MVC as you will need to provide routes. 
###Sign In
Now that we have got our Sign up we need our users to be able to see in. Create Sign methods in your authController.
```
  public function getSignin()
    {
        return view('auth.signin');
    }
    public function postSignin(Request $request)
    {
        $this->validate($request, [
            'email'=>'required',
            'password'=>'required',
        ]);

        if(!Auth::attempt($request->only(['email','password']),$request->has('remember')))
        {
            return redirect()->back()->with('info','Could not sign you in with those details.');
        }
        return redirect()->route('home')->with('info','You are now Signed in.');
    }
```
Next create your signin.blade.php file in your views->auth folder.

```
@extends('templates.default')

@section('content')
<h3> Sign In </h3>
    <form class="form-vertical" role="form" method ="post" action="{{route('auth.signin')}}">
        <div class="form-group">
            <label for="email" class="control-label">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email"name="email" value="{{Request::old('email')?:''}}">
            @if($errors->has('email'))
                <span class="help-block">{{$errors->first('email')}}</span>
            @endif
        </div>
        <div class="form-group{{$errors->has('password')? ' has-error': ''}}">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="password" name ="password" placeholder="Enter password">
            @if($errors->has('password'))
                <span class="help-block">{{$errors->first('password')}}</span>
            @endif
        </div>
        <div class="checkbox">
            <label><input type="checkbox"> Remember me</label>
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </div>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
  </form>
@stop
```
You also need to update your routes .
```
/*Signin Routes*/
Route::get('/signin',[
    'uses'=>'\Chatty\Http\Controllers\AuthController@getSignin',
    'as'=>'auth.signin',
]);

Route::post('/signin',[
    'uses'=>'\Chatty\Http\Controllers\AuthController@postSignin',
]);
```
You also need to use Auth built in library for Laravel. 
###Implementing the User's Name

In your user model  create following  methods
```
```
###SignOut 

In your auth controller implement a sign out method.

```
public function getSignout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
```
update navigation page
```
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{route('home')}}">Chatty</a>
    </div>
    <div class="collapse navbar-collapse">
        @if (Auth::check())
            <ul class="nav navbar-nav">
                <li><a href="#">Timeline</a></li>
                <li><a href="#">Friends</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search" action="#">
                <div class ="form-group">
                    <input type ="text" name="query" class="form-control" placeholder ="Find People">
                </div>
                <button class="btn btn-success" type="submit">Search</button>
            </form>
        @endif
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())    
                    <li><a href ="{{Auth::user()->getNameOrUsername()}}">{{Auth::user()->getNameOrUsername()}}</a></li>
                    <li><a href="#">Update profile</a></li>
                    <li><a href="{{route('auth.signout')}}">Sign Out</a></li>
                @else
                    <li><a href="{{route('auth.signup')}}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="{{route('auth.signin')}}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                @endif
            </ul>
    </div>
  </div>
</nav>
```

###Searching for People

First, sign up for some account.(Make sure you remember the password).
Create a search controller.
```
<?php

namespace Chatty\Http\Controllers;

class SearchController extends Controller
{
    public function getResults()
    {
        return view ('search.results');
    }
}
```
Now create a view. Create folder search in resources and create a file result.blade.php
```
@extends('templates.default')

@section('content')
    <h3> Your search for "{{ Request::input('query') }}"</h3>

    @if (!$users->count())
        <p>No results found, sorry. </p>
    @else
        <div class="row">
            <div class="col-lg-12">
                @foreach($users as $user)
                    @include('user/partials/userblock')
                @endforeach            
            </div>
        </div>
    @endif
@stop
```
Next, create a route
```
Route::get ('/search',[
    'uses'=>'\Chatty\Http\Controllers\SearchController@getResults',
    'as'=>'search.results',
]);
```
Lets hook the navigation so in your navigation folder edit the following code
```
<form class="navbar-form navbar-left" role="search" action="{{route('search.results')}}">
```

Next, create a user view. create folder User and then create folder partials. Create a new file userblock.blade.php
```
<div class="media">
    <a class="pull-left" href="#">
        <img class="media-object" alt="{{ $user->getNameOrUsername ()}}" src="">
    </a>
    <div class="media-body">
        <h4 class="media-heading"><a href="#">{{ $user->getNameOrUserName() }}</a></h4>
        @if ($user->location)
            <p>{{ $user->location }}</p>
        @endif
    </div>
</div>
```
###Profile Pictures

For this, we will be using Gravatar lots of website use this for profile pics. The easiest way of doing this implementing a method in User Model.
```
public function getAvatarUrl()
    {
        return "https://www.gravatar.com/avatar/{{md5($this->email)}}";
    }
```