<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Auth;

class TicketsAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Ticket::latest()->get();
            $usr = User::get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<div class="text-center">
                                        <a href="detail/'.$row->slug.'" class="btn btn-warning text-white btn-xs">Details</a>
                                   </div>';
    
                        return $btn;
                    })
                    ->addColumn('picture', function($row){
                        return '<a href="/storage/images/' . $row->picture . '" data-lightbox="' . $row->picture . '"><img src="/storage/images/' . $row->picture . '" width="100" class="img-thumbnail"></a>';
                    })
                    ->addColumn('assigned_to', function($row) use ($usr){
                        $usr = User::where('id', $row->assigned_to)->get();
                        foreach($usr as $u){
                            return $u->email;
                        }
                    })
                    ->addColumn('user_id', function($row) use ($usr){
                        $usr = User::where('id', $row->user_id)->get();
                        foreach($usr as $u){
                            return $u->email;
                        }
                    })
                    ->rawColumns(['user_id', 'assigned_to', 'picture', 'action'])
                    ->make(true);
        }

        return view('admin.tickets');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Ticket::updateOrCreate(['id' => $request->id],
                ['user_id' => $request->user_id, 'title' => $request->title, 'slug' => Str::slug($request->get('title')), 'description' => $request->description,
                'assigned_to' => $request->assigned_to, 'status' => $request->status, 'due_on' => $request->due_on]);       
   
        return response()->json(['success'=>'User data saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detail($slug)
    {
        $ticket = Ticket::where('slug', $slug)->first();
        return view('admin.details', compact('ticket'));
    }
}
