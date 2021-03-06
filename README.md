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
Also update userblock view
```
<div class="media">
    <a class="pull-left" href="#">
        <img class="media-object" alt="{{ $user->getNameOrUsername ()}}" src="{{ $user->getAvatarUrl()}}">
        
    </a>
    <div class="media-body">
        <h4 class="media-heading"><a href="#">{{ $user->getNameOrUserName() }}</a></h4>
        @if ($user->location)
            <p>{{ $user->location }}</p>
        @endif
    </div>
</div>
```
###User Profile

First, we create a Profile controller i.e ProfileController.php

```
class ProfileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::where('username',$username)->first();
        if (!$user)
        {
            abort(404);
        }
        return view('profile.index');
    }
}
```

Implement the controller in routes
```
/**
*Profile
*/
Route::get('/user/{username}',[
    'uses'=>'\Chatty\Http\Controllers\ProfileController@getProfile',
    'as'=>'profile.index',
]);
```

Hook this to the view
```
<div class="media">
    <a class="pull-left" href="{{ route('profile.index',['username'=>$user->username]) }}">
        <img class="media-object" alt="{{ $user->getNameOrUsername ()}}" src="{{ $user->getAvatarUrl()}}">
        
    </a>
    <div class="media-body">
        <h4 class="media-heading"><a href="{{ route('profile.index',['username'=>$user->username]) }}">{{ $user->getNameOrUserName() }}</a></h4>
        @if ($user->location)
            <p>{{ $user->location }}</p>
        @endif
    </div>
</div>
```

Next, we create a new view. Create folder in resources->profile  and add file index.blade.php

```

@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <!--User information and status-->
        </div>
        <div class="col-lg-4 col-lg-offset-3">
            <!--Friends, and friends request-->
        </div>
    </div>
@stop
```
Update you navigation.blade.php. 
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
            <form class="navbar-form navbar-left" role="search" action="{{route('search.results')}}">
                <div class ="form-group">
                    <input type ="text" name="query" class="form-control" placeholder ="Find People">
                </div>
                <button class="btn btn-success" type="submit">Search</button>
            </form>
        @endif
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())    
                    <li><a href ="{{ route('profile.index', ['username'=>Auth::user()->username]) }}">{{Auth::user()->getNameOrUsername()}}</a></li>
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
now when you click your username you should be able to see your profile
###Updating Profile Information
Add functions in you profile controller
```
   public function postEdit(Request $request)
    {   // the First argument is the data and second is array of options field you can include as many fields you like
        $this->validate($request,[
            'first_name'=>'alpha|max:50',
            'first_name'=>'alpha|max:50',
            'location'=>'max:25',
        ]);
        Auth:: user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'location' => $request->input('location'),
        ]);
        return  redirect()
            ->route('profile.edit')
            ->with('info','Your profile has been updated.');
    }
```
Now add edit view in your views profile folder i.e edit.blade.php
```

@extends('templates.default')

@section('content')
    <h3> Update your profile</h3>
    <div class="row">
        <div class="col-lg-6">
            <form class="form-vertical" role="form" method="post" action="{{route ('profile.edit')}}">
                <div class="row">
                    <!--edit First Name-->
                    <div class="col-lg-6"> 
                        <div class="form-group">
                            <label for="first_name" class="control-label">First Name: <label>
                            <input type ="text" name="first_name" class="form-control" id="first_name" value="{{ Request::old('first_name') ?: Auth::user()->first_name }}"> <!--value old data from db-->
                        </div>
                    </div>
                    <!--edit Last Name-->
                    <div class="col-lg-6"> 
                        <div class="form-group">
                            <label for="last_name" class="control-label">Last Name: <label>
                            <input type ="text" name="last_name" class="form-control" id="last_name" value="{{ Request::old('last_name') ?: Auth::user()->last_name }}">
                        </div>
                    </div>
                    <!--edit Location-->
                    <div class="col-lg-6"> 
                        <div class="form-group">
                            <label for="Location" class="control-label">Location: <label>
                            <input type ="text" name="Location" class="form-control" id="location" value="{{ Request::old('location') ?: Auth::user()->location }}">
                        </div>
                    </div>
                    <!--edit button-->
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div> 
    </div>
@stop
```
update routes
```
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
```
update you navigation.blade.php

```
<li><a href="{{route ('profile.edit')}}">Update profile</a></li>
```
###Friend table migration
create a new migrations
```
php artisan make:migration create_friends_table
```
in the new file inside database -> migrations '2017_02_27_080721_create_friends_table.php'
edit the file
```
 public function up()
    {
        Schema::create ('friends',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('friend_id');
            $table->boolean('accepted');//same as tiny int in SQL
            $table->timestamps();
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
in you console enter the following command
```
php artisan migrate
```
###Showing Friends

create the following methods in your user model
```
public function friendsOfMine()
    {
        return $this->belongsToMany('Chatty\Models\User','friends','user_id','friend_id');//friend is pivot table
    }
    public function friendOf()
    {
        return $this->belongsToMany('Chatty\Models\User','friends','friend_id','user_id');//friend is pivot table
    }
    public function friends()
    {
        return $this->friendsOfMine()
                    ->wherePivot('accepted',true)
                    ->get()//collection
                    ->merge($this->friendOf()//This is done to create two way relationship Alex friends with Dale and Dale friends with Alex even though Alex add Dale as a Friend
                    ->wherePivot('accepted','true')->get());
    }
```
change your profile index.blade.php page
```
<div class="col-lg-4 col-lg-offset-3">
            
@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            @include('user.partials.userblock')
            <hr>
        </div>
        <div class="col-lg-4 col-lg-offset-3">
            <h4>{{ $user->getFirstNameOrUsername() }}'s friends.</h4>
            @if (!$user->friends()->count())
                <p>{{ $user->getFirstNameOrUsername()}} has no friends</p>
            @else
                @foreach ($user->friends() as $user)
                    @include('user/partials/userblock')
                @endforeach
            @endif
        </div>
    </div>
@stop
</div>
```
###Friends Page

First create a friend controller-> FriendController.php
```
<?php

namespace Chatty\Http\Controllers;


Use Illuminate\Http\Request;
Use Chatty \Models\User;
Use DB;

class FriendsController extends Controller
{
    public function getIndex()
    {
        return view('friend.index');
    }
}
```
create new view. Create folder friend. create new file index.blade.php
```
@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h3>Your Friends</h3>
            @if (!$friends->count())
                <p>Its lonely in here :( You have no friends</p>
            @else
                @foreach ($friends as $user)
                    @include('user/partials/userblock')
                @endforeach
            @endif
        </div>
        <div class="col-lg-6">
            <h3>Friends Request</h3>
            <!--List of Friends Request-->
        </div>
    </div>
@stop
```
now we need a route
```
Route::get('/friends',[
    'uses'=>'\Chatty\Http\Controllers\FriendController@getIndex',
    'as'=>'friend.index',
    'middleware'=>['auth'],//middleware'=>['auth'] will allow only signed users to see friends
]);
```
update the navigation page
```
<li><a href="{{ route ('friend.index') }}">Friends</a></li>
```
###Showing Friends Requests

Add new method in user model

```
    public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted',false)->get();
    }
```
update your friend controller
```
class FriendController extends Controller
{
    public function getIndex()
    {
        $friends = Auth::user()->friends();
        $requests = Auth::user()->friendRequests();

        return view('friend.index')
            ->with('friends',$friends)
            ->with('requests',$requests);
    }
}
```
update your friend index
```
@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h3>Your Friends</h3>
            @if (!$friends->count())
                <p>Its lonely in here :( You have no friends</p>
            @else
                @foreach ($friends as $user)
                    @include('user/partials/userblock')
                @endforeach
            @endif
        </div>
        <div class="col-lg-6">
            <h3>Friends Request</h3>
            @if (!$requests->count())
                <p>You have no friend request./p>
            @else
                @foreach ($requests as $user)
                    @include('user.partials.userblock')
                @endforeach
            @endif
        </div>
    </div>
@stop
```
###Friend model methods
update your user model
```
  public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted',false)->get();
    }
    public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted',false)->get();
    }
    public function hasFriendRequestPending(User $user)
    {
        return(bool) $this->friendRequestsPending()->where('id',$user->id)->count();
    }
    public function hasFriendRequestReceived(User $user)
    {
        return(bool) $this->friendRequests()->where('id',$user->id)->count();
    }
    public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }
    public function acceptFriendRequest(user $user)
    {
        $this->friendRequests()->where('id',$user->id)->first()->pivot->
        update([
            'accepted'=>true,
        ]);
    }
    public function isFriendsWith(User $user)
    {
        return(bool) $this->friends()->where('id',$user->id)->count();
    }
```
 than duplicating the function I am just putting this inside my model and this makes it lot easier to work with. 

update your view . view->profel->index
```

@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            @include('user.partials.userblock')
            <hr>
        </div>
        <div class="col-lg-4 col-lg-offset-3">
            @if(Auth::user()->hasFriendRequestPending($user))
                <p>Waiting for {{ $user->getNameOrUsername() }} to accept your request. </p>
            
            @elseif(Auth::user()->hasFriendRequestReceived($user))
                <a href="#" class="btn btn-primary">Accept friend Request</a>
            
            @elseif(Auth::user()->isFriendsWith($user))
                <p>You and {{ $user->getNameOrUsername() }} are friends. </p>
            @else
            <a href="#" class="btn btn-info">Add as friend</a>
            @endif
            <h4>{{ $user->getFirstNameOrUsername() }}'s friends.</h4>
            @if (!$user->friends()->count())
                <p>{{ $user->getFirstNameOrUsername()}} has no friends</p>
            
            @else
                @foreach ($user->friends() as $user)
                    @include('user/partials/userblock')
                @endforeach
            @endif
        </div>
    </div>
@stop
```
###Sending friend requests
We need a method inside our friend's controller
```
public functions getAdd($username)
    {
         $user = User::where('username',$username)->first();

        if (!$user)
        {
            return redirect()
                ->route('home')
                ->with('info','That user count not be found');
        }

        if (Auth::user()-> hasFriendRequestPending($user)||$user->
            hasFriendRequestPending(Auth::user()))
            {
                return redirect()
                    ->route('profile.index',['username'=>$user->username])
                    ->with('info','Friend request already pending');
            }

        if (Auth::user()-> isFriendsWith($user))
        {
            return redirect()
                    ->route('profile.index',['username'=>$user->username])
                    ->with('info','Already Friends');
        }
        Auth::user()->addFriend($user);

        return redirect()
            ->route('profile.index',['username'=>$username])
            ->with('info','Friend request sent.');
    }
```

let's route this
```
Route::get('/friends/add/{username}',[
    'uses'=>'\Chatty\Http\Controllers\FriendController@getAdd',
    'as'=>'friend.add',//you got a method as in getAdd
    'middleware'=>['auth'],//middleware'=>['auth'] will allow only signed users to see friends
]);
```

Hook up the controller to a profile index view
```
<a href="{{ route('friend.add',['username'=>$user->username]) }}" class="btn btn-info">Add as friend</a>
            
```
###Accept Friend
Create the following function in your friends controller.
public function getAccept($username)//accept friend request
    {
        $user = User::where('username',$username)->first();

        if (!$user)//check to see if the user exits
        {
            return redirect()
                ->route('home')
                ->with('info','That user count not be found');
        }
        if (!Auth::user()->hasFriendRequestReceived($user)) 
        {
            return redirect()->route('home');
        }
        Auth::user()->acceptFriendRequest($user);
        return redirect()
            ->route('profile.index',['username'=>$username])
            ->with('info','Friend request accepted.');
    }
}
 head over to routes and implement the following routes.

Route::get('/friends/accept/{username}',[
    'uses'=>'\Chatty\Http\Controllers\FriendController@getAccept',
    'as'=>'friend.Accept',//you got a method as in getAdd
    'middleware'=>['auth'],//middleware'=>['auth'] will allow only signed users to see friends
]);

hook this to our view

```
 @elseif(Auth::user()->hasFriendRequestReceived($user))
                <a href="{{ route ('friend.Accept',['username'=>$user->username]) }}" class="btn btn-primary">Accept friend Request</a>
            
```
##Showing the timeline page

Go to Home controller and create a different view of the user is signed in. 
```
<?php

namespace Chatty\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::check())
        {
            return view('timeline.index');
        }
        return view ('home');
    }
}
```
create new view. create folder timeline->index.blade.php
```
@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form role="form" action="#" method="post">
                <div class="form-group">
                    <textarea placeholder="What's on your mind?"name="status"
                    class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-default">Update status</button>
            </form>
            <hr>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-5">
        <!--Timeline statuses and replies-->
        </div>
    </div>
@stop
```
###Status table migration
Lets create the status table.  Run the following command in your window. 
```
php artisan make:migration create_statuses_table
```
open the 2017_03_07_073225_create_statuses_table.php file and create your table
```
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('statuses',function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('parent_id')->nullable();
            $table->text('body');
            $table->timestamps();
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
        Schema::drop('statuses');
    }
}

```
Now run the migration and this will create our table
```
php artisan migrate
```
