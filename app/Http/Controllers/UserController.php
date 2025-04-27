<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view("admin.user",compact("users"));
    }

    public function delete($id){
        $users = User::findOrFail($id);
        $users->delete();
        return redirect()->back();
    }

    public function updateRole(Request $request, $id){
        $user = User::findOrFail($id);

        // Only allow admin to update
        if (Auth::user()->usertype !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'usertype' => 'required|in:user,librarian,admin',
        ]);

        $user->usertype = $request->usertype;
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully!');
    }

}
