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
        return view('friend.index')
            ->with('friends',$friends);
    }
}