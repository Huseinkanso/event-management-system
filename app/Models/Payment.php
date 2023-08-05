<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'product_id',
        'product_type',
        'amount',
        'payment_id',
    ];
    public function product()
    {
        return $this->morphTo();
    }
}
