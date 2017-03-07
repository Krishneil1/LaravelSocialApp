<?php

namespace Chatty\Http\Controllers;

use Auth;
Use Illuminate\Http\Request;
Use Chatty \Models\User;

class FriendController extends Controller
{
    public function getIndex()//index
    {
        $friends = Auth::user()->friends();
        $requests = Auth::user()->friendRequests();

        return view('friend.index')
            ->with('friends',$friends)
            ->with('requests',$requests);
    }
    public function getAdd($username)//add friends
    {
        $user = User::where('username',$username)->first();

        if (!$user)
        {
            return redirect()//check to see if the user exits
                ->route('home')
                ->with('info','That user count not be found');
        }

        if(Auth::user()->id=== $user->id)
        {
            return redirect()
                ->route('home');
        }

        if (Auth::user()-> hasFriendRequestPending($user)||$user->
            hasFriendRequestPending(Auth::user()))//check to see if there is a pending request
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