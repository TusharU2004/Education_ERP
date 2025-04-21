<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:View Users')->only(['index']);
        $this->middleware('permission:Edit Users')->only(['edit']);
        $this->middleware('permission:Create Users')->only(['create']);
        $this->middleware('permission:Delete Users')->only(['destroy']);
    }


    public function index()
    {
        $users = User::whereIn('usertype', ['employee', 'admin'])->get();
        return view('backend.user.view_user', compact('users'));
    }


    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('backend.user.create_user', compact('roles'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        $user = new User();
        $code = rand(0000, 9999);
        $user->usertype = 'Admin';
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->code = $code;
        $user->role = implode($request->role);

        if ($user->save()) {
            $user->syncRoles($request->role);
            $notification = array(
                'message' => 'User Inserted Successfully',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Error To Insert User',
                'alert-type' => 'error'
            );
        }

        return redirect()->route('users.view')->with($notification);

    }


    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::find($id);
        $roles = Role::orderBy('name', 'ASC')->get();
        $hasRoles = $user->roles->pluck('id');
        return view('backend.user.edit_user', compact('user', 'roles', 'hasRoles'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id . ',id'
        ]);
        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role ? implode($request->role) : null;
        if ($user->save()) {
            $user->syncRoles($request->role);
            $notification = array(
                'message' => 'User Inserted Successfully',
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => 'Error To Insert User',
                'alert-type' => 'error'
            );
        }

        return redirect()->route('users.view')->with($notification);

    }


    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        $notification = array(
            'message' => 'User Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('users.view')->with($notification);

    }

}