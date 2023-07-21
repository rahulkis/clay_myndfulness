<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function dashboard()
    {
        $user = new User;
        $online_users = User::whereHas("tokens",
            function($query){
                $query->where("last_used_at", ">=", now()->subMinute(3));
            }
        )->count();
        return view('dashboard', compact('online_users'));
    }

    public function changePassword()
    {
        return view("auth.change-password");
    }
    public function changePasswordPost(AdminChangePasswordRequest $request)
    {
        // dd($request->all());
        /**
         * @var $user \App\Models\Admin
         */
        $user = auth()->user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()
                ->back()
                ->with("success", "Password successfully changed.");
        } else {
            return redirect()
                ->back()
                ->with("error", "old password does not matched.");
        }
    }
}
