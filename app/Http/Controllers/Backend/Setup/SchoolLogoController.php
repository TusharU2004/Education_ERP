<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolLogoController extends Controller 
{

    public function __construct(){
        $this->middleware('permission:Manage School Logo')->only(['edit','update']);
    }
    function edit(){
        return view('backend.setup.logo.edit');
    }

    function update(Request $request){
        $request->validate([
            'image' => 'required'
        ]);

        $file = $request->file('image');
        @unlink('public/upload/school_logo.png');
        $file->move(public_path('upload/'),'school_logo.png');
        $notification = array(
            'message' => 'Logo updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('school.logo')->with($notification);

    }
}
