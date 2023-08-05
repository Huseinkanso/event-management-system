<?php

namespace App\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ticket_count'=>$this->ticket_count,
            'event'=>$this->event, // new EventResource($this->event) ---> return the event collection
            'created_at'=>$this->created_at->format('M d Y h:i A')
        ];
    }
}
