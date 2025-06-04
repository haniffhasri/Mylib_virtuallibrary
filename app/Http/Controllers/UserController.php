<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\SearchLog;
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

    public function search(Request $request){
        $query = $request->input('q');
        $username = $request->input('username');
        $usertype = $request->input('usertype');
        $name = $request->input('name');
        $sort = $request->input('sort', 'latest');

        $userQuery = User::query();

        // Apply full-text search if present
        if ($query) {
            $userQuery->whereRaw("search_vector @@ websearch_to_tsquery('english', ?)", [$query])
                    ->orderByRaw("ts_rank(search_vector, websearch_to_tsquery('english', ?)) DESC", [$query]);
        }

        // Apply filters
        if ($usertype) {
            $userQuery->where('usertype', $usertype);
        }

        if ($username) {
            $userQuery->where('username', $username);
        }

        if ($name) {
            $userQuery->where('name', $name);
        }

        // Sort
        if ($sort === 'oldest') {
            $userQuery->orderBy('created_at', 'asc');
        } else {
            $userQuery->orderBy('created_at', 'desc');
        }

        $users = $userQuery->paginate(10)->withQueryString();

        // Fallback to ILIKE if no results
        if ($query && $users->isEmpty()) {
            $fallbackQuery = User::query()
                ->where('username', 'ILIKE', '%' . $query . '%')
                ->orWhere('name', 'ILIKE', '%' . $query . '%')
                ->orWhere('email', 'ILIKE', '%' . $query . '%');

            if ($usertype) {
                $fallbackQuery->where('usertype', $usertype);
            }

            if ($sort === 'oldest') {
                $fallbackQuery->orderBy('created_at', 'asc');
            } else {
                $fallbackQuery->orderBy('created_at', 'desc');
            }

            $users = $fallbackQuery->paginate(10)->withQueryString();
        }

        // Log search
        if ($query) {
            SearchLog::create([
                'term' => $query,
                'results' => $users->total(),
                'ip' => $request->ip(),
                'user_id' => Auth::id(),
                'type' => 'user',
            ]);
        }

        return view('admin.user', [
            'users' => $users,
            'query' => $query,
        ]);
    }
}
