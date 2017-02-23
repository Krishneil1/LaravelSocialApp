<?php

namespace Chatty\Http\Controllers;


Use Illuminate\Http\Request;
Use Chatty \Models\User;
Use DB;

class SearchController extends Controller
{
    public function getResults(Request $request)
    {
        $query=$request->input('query');
        if(!$query)
        {
            return redirect()->route('home');/*no need to perfomr search on empty*/
        }
        $users = User::where(DB::raw("CONCAT(first_name,' ', last_name)"), '
            LIKE',"%{$query}%")
            ->orWhere('username','LIKE',"%{$query}%")
            ->get();

        return view ('search.results')->with('users', $users);
    }
}