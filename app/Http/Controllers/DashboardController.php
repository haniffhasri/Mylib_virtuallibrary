<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show()
    {
        $users = Auth::user();
        if (Auth::id()) {
            $usertype = Auth::user()->usertype;
            if (in_array($usertype, ['admin', 'librarian', 'user'])) {
                return view('dashboard', compact('users'));
            }
            else {
                return view('profile', compact('users'));
            }
        }
    }
    
}
