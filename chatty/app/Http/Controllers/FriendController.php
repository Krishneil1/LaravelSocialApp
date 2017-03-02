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
}