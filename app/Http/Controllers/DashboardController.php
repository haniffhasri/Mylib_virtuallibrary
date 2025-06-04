<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Borrow;

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
            $userId = Auth::id();
            $borrows = Borrow::with('book')->where('user_id', $userId)->where('is_active', true)->paginate(3);
            return view('dashboard', compact('users', 'borrows'));
        }
        else {
            abort(403, 'Unauthorized');
        }
    }

    public function viewUser($id)
    {
        $currentUser = Auth::user();

        if (!in_array($currentUser->usertype, ['admin', 'librarian'])) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        return view('admin.view', ['user' => $user]);
    }
}
