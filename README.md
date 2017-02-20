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