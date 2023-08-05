<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'job_title',
        'description',
        'company_name',
        'twitter_url',
        'facebook_url',
        'user_id',
        'stripe_account_id',
    ];
    protected $with = ['user'];
    public function attachImage($image)
    {
        $filename = Storage::putFile('public/speaker/', $image);
        $this->update(['image' => $filename]);
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function updateImage($image)
    {
        Storage::delete('public/speaker/' . $this->image);
        $filename = Storage::putFile('public/speaker/', $image);
        $this->update(['image' => $filename]);
    }
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function user()
    {
        /////// cant load relation without her id (id in select)
        return $this->belongsTo(User::class, "user_id")->select('id','name', 'slug','email','type');
    }
}
