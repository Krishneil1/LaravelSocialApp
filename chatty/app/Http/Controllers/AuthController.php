<?php

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