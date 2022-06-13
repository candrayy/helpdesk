<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\Datatables\Datatables;
use Auth;

class UsersAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<div class="text-center">
                                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning text-white editUser"><i class="bi bi-pencil-fill">Edit</i></a>
                                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-outline-danger text-warning deleteUser"><i class="bi bi-trash2-fill">Delete</i></a>
                                   </div>';
    
                        return $btn;
                    })
                    ->addColumn('role_id', function($row){
                        return $row->role->role_name;
                    })
                    ->rawColumns(['action', 'role_id'])
                    ->make(true);
        }

        return view('admin.users');
    }

    public function store(Request $request)
    {
        User::updateOrCreate(['id' => $request->id],
                ['role_id' => $request->role_id, 'name' => $request->name, 'email' => $request->email, 'status' => $request->status]);        
   
        return response()->json(['success'=>'User data saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
     
        return response()->json(['success'=>'User data deleted successfully.']);
    }
}
