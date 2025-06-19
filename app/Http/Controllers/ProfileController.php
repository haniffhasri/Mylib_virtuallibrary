<?php

namespace App\Http\Controllers;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use Soap\Sdl;

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
            $imageName = 'profile_picture/' . time() . '.' . $profile_picture->getClientOriginalExtension();

            $result = Storage::disk('s3')->put($imageName, file_get_contents($profile_picture));
            Log::info('S3 upload result:', ['path' => $imageName, 'result' => $result]);

            $user->profile_picture = $imageName;
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profile picture uploaded.');
    }
    
    public function edit($id){
        $users = User::findOrFail($id);
        return view('user.edit', compact('users'));
    }

    public function update(Request $request, $id){
        try {
            $users = User::findOrFail($id);

            $request->validate([
                'name' => 'required',
                'profile_picture' => 'image|mimes:jpg,jpeg,png|max:2048',
                'bio' => 'nullable|string',
            ]);

            $users->name = $request->name;
            $users->bio = $request->bio;

            if ($request->hasFile('profile_picture')) {
                // Delete old profile picture if not default
                if ($users->profile_picture && $users->profile_picture !== 'default.jpg') {
                    if (Storage::disk('s3')->exists($users->profile_picture)) {
                        Storage::disk('s3')->delete($users->profile_picture);
                    }
                }

                // Upload new profile picture
                $profile_picture = $request->file('profile_picture');
                $imageName = 'profile_picture/' . time() . '_profile.' . $profile_picture->getClientOriginalExtension();
                Storage::disk('s3')->put($imageName, file_get_contents($profile_picture));
                $users->profile_picture = $imageName;
            }

            $users->save();

            return redirect('dashboard')->with('success', 'Profile updated!');
        } catch(Exception $e){
            Log::error('Profile update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update your profile.');
        }
    }
}
