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