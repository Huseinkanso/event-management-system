<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'comment'=>$this->comment,
            'user_name'=>$this->user->name,
            'user_slug'=>$this->user->slug,
            'user_id'=>$this->user->id,
            'created_at'=>Carbon::parse($this->created_at)->diffForHumans(),
            'updated_at'=>Carbon::parse($this->updated_at)->diffForHumans(),
            'replies'=>ReplyResource::collection($this->replies),
        ];
    }
}
