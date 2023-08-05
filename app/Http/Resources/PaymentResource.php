<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount'=>$this->amount/100, // in cent,
            'payment_id'=>$this->payment_id,
            'product'=> new EventResource($this->product),
            'created_at'=> $this->created_at->format('d M ,Y'),
        ];
    }
}
