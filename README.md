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

###Alert Message

This will provide simple alerts for example when the use signs up our social net work.
create a new file inside partials and name id alerts.blade.php.
```
@if(Session::has('info'))
    <div class="alert alert-info" role="alert">
    {{Session::get('info')}}
    </div>
@endif
``
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
and refresh the page http://localhost:8000/alert

and how you should see you alert message 
```
You have signed up!
```
