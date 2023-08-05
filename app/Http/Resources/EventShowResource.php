<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id'=>$this->id,
            'name' => $this->name,
            'speaker_name' => $this->speaker_name,
            'speaker_slug' => $this->speaker_slug,
            'description' => $this->description,
            'slug' => $this->slug,
            'speaker_id' => $this->speaker_id,
            'address' => $this->address,
            'longitude'=>$this->longitude,
            'latitude'=>$this->latitude,
            'image' => asset(str_replace('public', 'storage', $this->image)),
            'ticket_price' => $this->ticket_price,
            'ticket_remaining' => $this->ticket_remaining,
            'ticket_number' => $this->ticket_number,
            'date' => $this->date,
            'categorie_name' => $this->categorie_name,
            'published_at' => $this->published_at,
            'comments'=>CommentResource::collection($this->comments)
        ];
    }
}
