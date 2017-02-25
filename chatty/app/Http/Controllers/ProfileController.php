<?php

namespace Chatty\Http\Controllers;


Use Illuminate\Http\Request;
Use Chatty \Models\User;
Use Auth;

class ProfileController extends Controller
{
    public function getProfile($username)//referred back in routes as profile
    {
        $user = User::where('username',$username)->first();
        if (!$user)
        {
            abort(404);
        }
        return view('profile.index')->with('user',$user);
    }
    public function getEdit()//referred back in routes as edit
    {
        return view('profile.edit');
    }
    public function postEdit(Request $request)
    {   //First argument is the data and second is array of options field you can include as many fields you like
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
}