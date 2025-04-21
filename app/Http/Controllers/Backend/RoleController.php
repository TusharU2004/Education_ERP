<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:View Roles')->only(['index']);
        $this->middleware('permission:Edit Roles')->only(['edit']);
        $this->middleware('permission:Create Roles')->only(['create']);
        $this->middleware('permission:Delete Roles')->only(['destroy']);
    }

    public function index()
    {
        $roles = Role::all();
        return view('backend.roles.view_roles', compact('roles'));
    }


    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('backend.roles.create_roles', compact('permissions'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|min:3'
        ]);

        $role = new Role();
        $role->name = $request->name;
        if (!empty($request->permission)) {
            foreach ($request->permission as $name) {
                $role->givePermissionTo($name);
            }
        }
        if ($role->save()) {
            $notification = array(
                'message' => 'Role Created Successully',
                'alert-type' => 'success'
            );
            return redirect()->route('roles.view')->with($notification);
        } else {
            $notification = array(
                'message' => 'error to create Role',
                'alert-type' => 'error'
            );
        }
    }


    public function edit($id)
    {
        $role = Role::find($id);
        $hasPermission = $role->permissions->pluck('name');

        $permissions = Permission::all();

        return view('backend.roles.edit_roles', compact('role', 'hasPermission', 'permissions'));
    }


    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id . ',id|min:3'
        ]);

        $role->name = $request->name;

        if ($role->save()) {

            if (!empty($request->permission)) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }

            $notification = array(
                'message' => 'Roles Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('roles.view')->with($notification);

        } else {
            $notification = array(
                'message' => 'Error to update roles',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function destroy($id)
    {
        if (Role::find($id)->delete()) {
            $notification = array(
                'message' => 'Roles Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('roles.view')->with($notification);
        } else {
            $notification = array(
                'message' => 'Error To Delete Roles',
                'alert-type' => 'error'
            );
            return redirect()->route('roles.view')->with($notification);
        }
    }
}
