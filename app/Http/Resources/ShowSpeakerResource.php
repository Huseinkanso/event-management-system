<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowSpeakerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->user->name,
            'email'=>$this->user->email,
            'slug'=>$this->user->slug,
            'image'=>asset(str_replace('public', 'storage', $this->image)),
            'job_title'=>$this->job_title,
            'description'=>$this->description,
            'company_name'=>$this->company_name,
            'twitter_url'=>$this->twitter_url,
            'facebook_url'=>$this->facebook_url,
            'events'=>EventResource::collection($this->events->whereNotNull('published_at'))
        ];
    }
}
