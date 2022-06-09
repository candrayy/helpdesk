<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;
use Auth;

class TicketUserController extends Controller
{
    public function index()
    {
        $dataUsers = DB::table('roles')
            ->join('users', 'roles.id', '=', 'users.role_id')
            ->select('users.*')
            ->where('roles.id', 3)
            ->where('users.status', 'active')
            ->get();

        return view('user.ticket', compact('dataUsers'));
    }

    public function fetchAll()
    {
        $dtTicket = Ticket::where('user_id', Auth::user()->id)->latest()->get();
        // User::where('id', $tkt->assigned_to)->select('email')->get()
        $output = '';
        if($dtTicket->count() > 0){
            $output .= '<div style="overflow-x: auto"><table class="table table-striped table-sm text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            $no = 1;
            foreach($dtTicket as $tkt){
                $output .= '<tr>
                    <td>' . $no++ . '</td>
                    <td> <a href="/storage/images/' . $tkt->picture . '" data-lightbox="' . $tkt->picture . '"><img src="/storage/images/' . $tkt->picture . '" width="100" class="img-thumbnail"></a></td>
                    <td>' . $tkt->title . '</td>
                    <td>' . $tkt->description . '</td>
                    <td>' . $tkt->assigned_to . '</td>
                    <td>' . $tkt->status . '</td>
                    <td>
                        <a href="details/'. $tkt->slug. '" class="btn text-primary mx-1">Detail</a>
                        <a href="#" id="' . $tkt->id . '" class="btn text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editTicketModal">Edit</a>
                        <a href="#" id="' . $tkt->id . '" class="btn text-danger mx-1 deleteIcon">Delete</a>
                    </td>
                </tr>';
            }
            $output .= '</tbody></table></div>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }


    public function store(Request $request)
    {
        $file = $request->file('picture');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/images', $fileName);
    
        $ticketData = [
            'user_id' => $request->user_id,
            'picture' => $fileName,
            'title' => $request->title,
            'slug' => Str::slug($request->get('title')),
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'status' => $request->status,
            'due_on' => $request->due_on
        ];
        Ticket::create($ticketData);
        return response()->json([
            'status' => 200,
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $ticket = Ticket::find($id);
        return response()->json($ticket);
    }


    public function update(Request $request)
    {
        $fileName = '';
        $ticket = Ticket::find($request->tkt_id);
        if($request->hasFile('picture')){
            $file = $request->file('picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            if($ticket->picture){
                Storage::delete('public/images/' . $ticket->picture);
            }
        }else{
            $fileName = $request->tkt_picture;
        }
        
        $ticketData = [
            'user_id' => $request->user_id,
            'picture' => $fileName,
            'title' => $request->title,
            'slug' => Str::slug($request->get('title')),
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'status' => $request->status,
            'due_on' => $request->due_on
        ];

        $ticket->update($ticketData);
        return response()->json([
            'status' => 200,
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->id;
        $ticket = Ticket::find($id);
        if(Storage::delete('public/images/' . $ticket->picture)){
            Ticket::destroy($id);
        }
    }

    public function details($slug)
    {
        $ticket = Ticket::where('slug', $slug)->first();
        return view('user.detail', compact('ticket'));
    }
}
