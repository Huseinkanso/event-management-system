<?php

namespace App\Providers;

use App\Models\Payment;
use App\Providers\TicketSold;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreTicketInformation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    // the $event in arg is laravel event we need to acces the eventile event
    // we access the data of the event by $event->dataname that is stored in event
    public function handle(TicketSold $event): void
    {
        $eventile_event=$event->event;
        $ticket_count=$event->tikect_count;
        $amount=$event->amount;

        // $eventile_event->update([
        //     'ticket_remaining'=>$eventile_event->ticket_remaining - $ticket_count
        // ]);
        $eventile_event->decrement('ticket_remaining',$ticket_count);
        $eventile_event->tickets()->create([
            'user_id'=>auth()->user()->id,
            'ticket_count'=>$ticket_count,
            'event_id'=> $eventile_event->id
        ]);

        // like this code we add dynamically product id and product type using morph many to many
        $eventile_event->payments()->save(new Payment([
            'payment_id'=>$event->payment_id,
            'amount'=>$amount,
            'user_id'=>auth()->user()->id
        ]));
    }
}
