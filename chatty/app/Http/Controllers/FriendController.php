<?php

namespace Chatty\Http\Controllers;

use Auth;
Use Illuminate\Http\Request;
Use Chatty \Models\User;

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
    public function getAdd($username)
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
}