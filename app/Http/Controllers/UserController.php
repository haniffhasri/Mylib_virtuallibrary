<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


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

}
