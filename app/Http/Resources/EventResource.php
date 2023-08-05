<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{

    // /**
    //  * Customize the pagination information for the resource.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  array $paginated
    //  * @param  array $default
    //  * @return array
    //  */
    // public function paginationInformation($request, $paginated, $default)
    // {
    //     $default['links']['custom'] = 'https://example.com';

    //     return  $default;
    // }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'address' => $this->address,
            'date' => $this->date,
            'published_at' => $this->published_at,
            'image' => asset(str_replace('public', 'storage', $this->image)),
            'category'=>$this->category,
            // 'description' => $this->description,
            // !empty($this->speaker_name) && 'speaker_name' => $this->speaker_name,
            // !empty($this->speaker_slug) && 'speaker_slug' => $this->speaker_slug,
            // 'speaker_id' => $this->speaker_id,
            // 'ticket_price' => $this->ticket_price,
            // 'ticket_remaining' => $this->ticket_remaining,
            // 'ticket_number' => $this->ticket_number,
        ];

    }

}
