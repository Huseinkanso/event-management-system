<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeakerResource extends JsonResource
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
            'slug'=>$this->user->slug,
            'type'=>$this->user->type,
            'image'=>asset(str_replace('public', 'storage', $this->image)),
            'job_title'=>$this->job_title,
            'description'=>$this->description,
            'company_name'=>$this->company_name,
            'twitter_url'=>$this->twitter_url,
            'facebook_url'=>$this->facebook_url,
        ];
    }
}
