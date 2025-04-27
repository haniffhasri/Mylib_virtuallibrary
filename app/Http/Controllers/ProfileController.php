<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(){
        return view('auth.profile-picture');
    }

    public function store(Request $request){
        /** @var \App\Models\User $user */
        
        $user = Auth::user();
        // If user pressed skip
        if ($request->input('skip') == '1') {
            $user->profile_picture = 'default.jpg'; 
            $user->save();
            return redirect()->route('dashboard')->with('success', 'Profile picture set to default.');
        }

        $request->validate([
            'profile_picture' => 'required|image|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $image = time() . '.' . $profile_picture->getClientOriginalExtension();
            $profile_picture->move(public_path('profile_picture'), $image);
            $user->profile_picture = $image;
        }

        $user->save();

        return redirect()->route('dashboard')->with('success');
    }
    
    public function edit($id){
        $users = User::findOrFail($id);
        return view('user.edit', compact('users'));
    }

    public function update(Request $request, $id){
        $users = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'profile_picture' => 'image|mimes:jpg,jpeg,png|max:2048',
            'bio' => 'nullable|string'
        ]);

        $users->name = $request->name;
        $users->bio = $request->bio;

        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $image = time() . '.' . $profile_picture->getClientOriginalExtension();
            $profile_picture->move(public_path('profile_picture'), $image);
            $users->profile_picture = $image;
        }

        $users->save();

        return redirect('dashboard')->with('success', 'Profile updated!');
    }
}
