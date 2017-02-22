@extends('templates.default')

@section('content')
<h3> Join Us </h3>
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
        <div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </div>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
  </form>
@stop