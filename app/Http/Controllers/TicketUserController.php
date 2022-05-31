<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;
use Auth;

class TicketUserController extends Controller
{
    public function index(Request $request)
    {
        $dataUsers = DB::table('roles')
            ->join('users', 'roles.id', '=', 'users.role_id')
            ->select('users.*')
            ->where('roles.id', 3)
            ->where('users.status', 'active')
            ->get();

        if ($request->ajax()) {
            $data = Ticket::where('user_id', Auth::user()->id)->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<div class="text-center">
                                        <a href="details/'.$row->slug.'" class="btn btn-success btn-xs">Details</a>
                                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning text-white editUser"><i class="bi bi-pencil-fill">Edit</i></a>
                                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-outline-danger text-warning deleteUser"><i class="bi bi-trash2-fill">Delete</i></a>
                                   </div>';
    
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('user.ticket', compact('dataUsers'));
    }

    public function store(Request $request)
    {
        // $datas = ['user_id' => $request->user_id, 'image'=>$fileName, 'title' => $request->title, 'description' => $request->description,
        //         'assigned_to' => $request->assigned_to, 'status' => $request->status, 'due_on' => $request->due_on];
        
        // if ($request->hasFile('image'))
        // {
        //     $file = $request->file('image');
        //     $extension = $file->getClientOriginalExtension();
        //     $fileName = time() . '.' . $extension;
        //     $file->move('public/tickets/', $fileName);
            
        // }

        Ticket::updateOrCreate(['id' => $request->id],
                ['user_id' => $request->user_id, 'title' => $request->title, 'slug' => Str::slug($request->get('title')), 'description' => $request->description,
                'assigned_to' => $request->assigned_to, 'status' => $request->status, 'due_on' => $request->due_on]);     
        
        // $tickets = Ticket::updateOrCreate(['id' => $request->id], $datas);

        return response()->json(['success'=>'User data saved successfully.']);
        // return response()->json($tickets);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);
        return response()->json($ticket);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ticket::find($id)->delete();
     
        return response()->json(['success'=>'User data deleted successfully.']);
    }

    public function details($slug)
    {
        $ticket = Ticket::where('slug', $slug)->first();
        return view('user.detail', compact('ticket'));
    }
}
