<?php

namespace App\Http\Controllers\Backend\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AccountOtherCost;

class OtherCostController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:School Account Management');
    }
    public function OtherCostView()
    {
        $allData = AccountOtherCost::orderBy('id', 'desc')->get();
        return view('backend.account.other_cost.other_cost_view', compact('allData'));
    }


    public function OtherCostAdd()
    {
        return view('backend.account.other_cost.other_cost_add');
    }


    public function OtherCostStore(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'required'
        ]);
        $cost = new AccountOtherCost();
        $cost->date = date('Y-m-d', strtotime($request->date));
        $cost->amount = $request->amount;

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') .".".$file->getClientOriginalExtension();
            $file->move(public_path('upload/cost_images'), $filename);
            $cost->image = $filename;
        }
        $cost->description = $request->description;
        $cost->save();

        $notification = array(
            'message' => 'Other Cost Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('other.cost.view')->with($notification);

    }


    public function OtherCostEdit($id)
    {
        $editData = AccountOtherCost::findOrFail($id);
        return view('backend.account.other_cost.other_cost_edit', compact('editData'));
    }



    public function OtherCostUpdate(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required',
            'description' => 'required'
        ]);
        $cost = AccountOtherCost::find($id);
        $cost->date = date('Y-m-d', strtotime($request->date));
        $cost->amount = $request->amount;

        if ($request->file('image')) {
            $file = $request->file('image');
            @unlink(public_path('upload/cost_images/' . $cost->image));
            $filename = date('YmdHi') .".".$file->getClientOriginalExtension();
            $file->move(public_path('upload/cost_images'), $filename);
            $cost->image = $filename;
        }
        $cost->description = $request->description;
        $cost->save();

        $notification = array(
            'message' => 'Other Cost Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('other.cost.view')->with($notification);

    }

    public function OtherCostDelete($id)
    {
        $id = AccountOtherCost::find($id);
        if ($id) {
            @unlink(public_path('upload/cost_images/' . $id->image));
            $id->delete();
            $notification = array(
                'message' => 'Other Cost Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('other.cost.view')->with($notification);
        } else {
            $notification = array(
                'message' => 'Please Select valid Action',
                'alert-type' => 'error'
            );
            return redirect()->route('other.cost.view')->with($notification);
        }
    }
}
