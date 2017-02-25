
@extends('templates.default')

@section('content')
    <h3> Update your profile</h3>
    <div class="row">
        <div class="col-lg-6">
            <form class="form-vertical" role="form" method="post" action="{{route ('profile.edit')}}">
                <div class="row">
                    <!--edit First Name-->
                    <div class="col-lg-6"> 
                        <div class="form-group {{ $errors->has('first_name') ? 'has-error':'' }}">
                            <label for="first_name" class="control-label">First Name: </label>
                            <input type ="text" name="first_name" class="form-control" id="first_name" value="{{ Request::old('first_name') ?: Auth::user()->first_name }}"> <!--value old data from db-->
                            @if ($errors->has('first_name'))
                                <span class="help-block">{{$errors->first('first_name')}}
                            @endif
                        </div>
                    </div>
                    <!--edit Last Name-->
                    <div class="col-lg-6"> 
                        <div class="form-group {{ $errors->has('last_name') ? 'has-error':'' }}">
                            <label for="last_name" class="control-label">Last Name: </label>
                            <input type ="text" name="last_name" class="form-control" id="last_name" value="{{ Request::old('last_name') ?: Auth::user()->last_name }}">
                            @if ($errors->has('last_name'))
                                <span class="help-block">{{$errors->first('last_name')}}
                            @endif
                        </div>
                    </div>
                    <!--edit Location-->
                    <div class="col-lg-12"> 
                        <div class="form-group {{ $errors->has('location') ? 'has-error':'' }}">
                            <label for="Location" class="control-label">Location: </label>
                            <input type ="text" name="location" class="form-control" id="location" value="{{ Request::old('location') ?: Auth::user()->location }}">
                            @if ($errors->has('location'))
                                <span class="help-block">{{$errors->first('location')}}
                            @endif
                        </div>
                    </div>
                    <!--edit button-->
                    <div class="col-lg-6"> 
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                    </div>
                </div>
                <input type="hidden" name="_token" value="{{ Session::token() }}">
            </form>
        </div> 
    </div>
@stop