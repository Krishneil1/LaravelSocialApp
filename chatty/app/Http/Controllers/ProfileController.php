<?php

namespace Chatty\Http\Controllers;


Use Illuminate\Http\Request;
Use Chatty \Models\User;


class ProfileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::where('username',$username)->first();
        if (!$user)
        {
            abort(404);
        }
        return view('profile.index')->with('user',$user);
    }
}