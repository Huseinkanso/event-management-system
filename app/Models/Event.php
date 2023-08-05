<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'ticket_price',
        'ticket_number',
        'address',
        'longitude',
        'latitude',
        'date',
        'category',
        'published_at',
        'speaker_id'
    ];

    // protected $casts=['date'=>'timestamp'];


    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeAvailable($query)
    {
        return $query->where('date', '>=', Carbon::now());
    }
    public function attachImage($image)
    {
        $filename = $image->store('public');
        $this->update(['image' => $filename]);
    }
    public function updateImage($image)
    {
        Storage::delete($this->image);
        $filename = Storage::disk('public')->put('', $image);
        $this->update(['image' => $filename]);
    }

    // public function getDateAttribute($date)
    // {
    //     return Carbon::parse($date)->format('Y-m-d');
    // }
    // public function getPublishedAtAttribute($date)
    // {
    //     return Carbon::parse($date)->format('Y-m-d');
    // }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            $event->slug = Str::slug($event->name);
            $event->ticket_remaining=$event->ticket_number;
        });
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function payments()
    {
        return $this->morphMany(Payment::class, 'product');
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }

}
