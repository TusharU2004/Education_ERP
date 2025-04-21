<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    public function ProfileView()
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        return view('student.user.view_profile', compact('user'));
    }

    public function PasswordView()
    {
        return view('student.user.edit_password');
    }

    public function PasswordUpdate(Request $request)
    {
        $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed'
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            return redirect('login');
        } else {
            return redirect()->back();
        }

    }
}
