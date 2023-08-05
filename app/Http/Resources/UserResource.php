<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'=>$this->name,
            'email'=>$this->email,
            'created_at'=>$this->created_at->format('M d Y h:i A'),
            'updated_at'=>$this->updated_at->format('M d Y h:i A'),
            'email_verified_at'=> $this->email_verified_at ? $this->email_verified_at->format('M d Y h:i A') : $this->email_verified_at,
            'type'=>$this->type
        ];
    }
}
