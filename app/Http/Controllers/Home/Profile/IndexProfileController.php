<?php

namespace App\Http\Controllers\Home\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexProfileController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $user_name = Auth::user()->name;
        $user_email = Auth::user()->email;

        return view("home.profile.index", compact("user_id" , "user_name" , "user_email"));
    }
    
    public function store($user_id, Request $request)
    {
        $user = User::where("id" , $user_id)->first();
        // dd($request->name, $user);

        $request->validate([
            "name" => "required",
            "email" => "required"
        ]);

        $user->update([
            "name" => $request->name,
            "email" => $request->email
        ]);

        alert()->success('موفق','اطلاعات کاربر با موفقیت ثبت شد');

        return redirect()->route("home.profile.index");   
    }
}
