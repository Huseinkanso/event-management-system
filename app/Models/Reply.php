<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $fillable=[
        'comment_id',
        'user_id',
        'reply',
        'parent_reply_id'
    ];
    protected $with = ['replies','user'];
    public function replies()  {
        return $this->hasMany(Reply::class,'parent_reply_id')->whereNotNull('parent_reply_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class)->select('id','name','slug');
    }
}
