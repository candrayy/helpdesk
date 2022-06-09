<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth;

class TechnicianTicketController extends Controller
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
            $data = Ticket::where('assigned_to', Auth::user()->id)->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<div class="text-center">
                                        <a href="detailss/'.$row->slug.'" class="btn btn-warning text-white btn-xs">Details</a>
                                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success text-white editTicket"><i class="bi bi-pencil-fill">Edit</i></a>
                                   </div>';
    
                        return $btn;
                    })
                    ->addColumn('picture', function($row){
                        return '<a href="/storage/images/' . $row->picture . '" data-lightbox="' . $row->picture . '"><img src="/storage/images/' . $row->picture . '" width="100" class="img-thumbnail"></a>';
                    })
                    ->addColumn('assigned_to', function($row){
                        return User::where('id', $row->assigned_to)->select('email')->get();
                    })
                    ->rawColumns(['assigned_to', 'picture', 'action'])
                    ->make(true);
        }

        return view('technician.ticket', compact('dataUsers'));
    }

    public function store(Request $request)
    {
        Ticket::updateOrCreate(['id' => $request->id],
                ['user_id' => $request->user_id, 'title' => $request->title, 'slug' => Str::slug($request->get('title')), 'description' => $request->description,
                'assigned_to' => $request->assigned_to, 'status' => $request->status, 'due_on' => $request->due_on]);       
   
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

    public function detailss($slug)
    {
        $ticket = Ticket::where('slug', $slug)->first();
        return view('technician.detail', compact('ticket'));
    }
}
