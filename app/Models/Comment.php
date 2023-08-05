<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'event_id',
        'comment',
    ];
    // this is where we register the relationship that we need it to come with comments
    protected $with = ['replies','user'];

    // we can query on the relationship here by chaining where functions
    public function replies() {
        return $this->hasMany(Reply::class)->where('parent_reply_id',null);
    }
    public function user()
    {
        return $this->belongsTo(User::class)->select('id','name','slug');
    }
}
