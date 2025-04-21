<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:View Permissions')->only(['index']);
        $this->middleware('permission:Edit Permissions')->only(['edit']);
        $this->middleware('permission:Create Permissions')->only(['create']);
        $this->middleware('permission:Delete Permissions')->only(['destroy']);
    }
    public function index(Request $request)
    {

        $query = Permission::query();

        if($request->ajax()){
            $permissions = $query->where('name','LIKE','%'.$request->search.'%')
                                ->paginate(5);
            return response()->json([
                'permissions'=> $permissions->items(),
                'pagination'=> (string) $permissions->links('pagination::bootstrap-4')
            ]);
        }
        $permissions = $query->paginate(5);    
        return view('backend.permission.view_permission', compact('permissions'));
    }


    public function create()
    {
        return view('backend.permission.create_permission');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions|min:3'
        ]);

        $permission = new Permission();
        $permission->name = $request->name;
        if ($permission->save()) {
            $notification = array(
                'message' => 'Permission Created Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('permission.view')->with($notification);
        } else {
            $notification = array(
                'message' => 'Error to Create Permission',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }


    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('backend.permission.edit_permission', compact('permission'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'. $id .'|min:3'
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->name;
        if ($permission->save()) {
            $notification = array(
                'message' => 'Permission Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('permission.view')->with($notification);
        } else {
            $notification = array(
                'message' => 'Permission not Updated',
                'alert-type' => 'error'
            );
            return redirect()->route('permission.view')->with($notification);
        }
    }

    public function destroy($id)
    {
        if (Permission::find($id)->delete()) {
            $notification = array(
                'message' => 'Permission Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('permission.view')->with($notification);
        } else {
            $notification = array(
                'message' => 'Error to Delete Permission',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

}
