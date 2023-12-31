<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable=['user_id','event_id','ticket_count'];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}


