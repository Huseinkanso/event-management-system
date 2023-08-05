<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            $event->slug = Str::slug($event->name);
        });
    }
    // will use slug attribute as binding routing
    // but the variable to bind is named user
    public function getRouteKeyName()
    {
        return 'slug';
    }
    // mutator
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function speaker()
    {
        return $this->hasOne(Speaker::class);
    }
    // public function sendPasswordResetNotification($token): void
    // {

    //     $url = 'http://localhost:3000/reset-password?token='.$token. $this->getEmailForPasswordReset();

    //     $this->notify(new ResetPasswordNotification($url));
    // }
    // public function sendEmailVerificationNotification()
    // {
    //     // Mail::to()->queue(new sendEmailVerification([
    //     //     'name'=>$this->name,
    //     //     'email'=>$this->email,
    //     //     'body'=>'click here to verify your url'
    //     // ]));
    //     Mail::to($this->email)->send(new EmailVerification([
    //         'name'=>$this->name,
    //         'email'=>$this->email,
    //         'body'=>'click here to verify your url',
    //         'url'=>'https://localhost/callback?id=&hash=',
    //     ]));
    // }

    // public function sendEmailVerificationNotification()
    // {
    //     // We override the default notification and will use our own
    //     $this->notify(new SendEmailVerificationNotification());
    // }
}
