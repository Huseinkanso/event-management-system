<?php

namespace App\Providers;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketSold
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event;
    public $tikect_count;
    public $amount;
    public $payment_id;
    /**
     * Create a new event instance.
     */
    public function __construct($event,$tikect_count,$amount,$payment_id)
    {
        $this->event=$event;
        $this->tikect_count=$tikect_count;
        $this->amount=$amount;
        $this->payment_id=$payment_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
