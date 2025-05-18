<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request){
        $sort = $request->query('sort', 'latest');

        $users = User::orderByRaw("
                    CASE usertype
                        WHEN 'admin' THEN 1
                        WHEN 'librarian' THEN 2
                        WHEN 'user' THEN 3
                        ELSE 4
                    END
                ")
                ->when($sort === 'latest', function ($query) {
                    return $query->orderBy('created_at', 'desc');
                })
                ->when($sort === 'oldest', function ($query) {
                    return $query->orderBy('created_at', 'asc');
                })
                ->paginate(10)
                ->withQueryString();

        return view("admin.user", compact("users"));
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
