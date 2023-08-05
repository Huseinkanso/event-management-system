<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets=auth()->user()->tickets;
        foreach($tickets as $ticket)
        {

            $ticket->event=Event::where('id',$ticket->event_id)->select('name','date')->get();
            $ticket->event[0]->date=Carbon::parse($ticket->event[0]->date)->format('M d Y h:i A');
        }
        return  TicketResource::collection(
            // collect($tickets)->map(function($ticket){
            //     $ticket->event= Event::where('id',$ticket->event)->get('name');
            // })->toArray()
            $tickets
        );
    }
}
