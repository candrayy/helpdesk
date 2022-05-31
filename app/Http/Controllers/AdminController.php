<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comment;
use Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ticket = Ticket::count();
        $comment = Comment::count();
        return view('admin.admin', compact('ticket', 'comment'));
    }

}
