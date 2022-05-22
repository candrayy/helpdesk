<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'title', 'description', 'assigned_to', 'status', 'image', 'due_on'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
