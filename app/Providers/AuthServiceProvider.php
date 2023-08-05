<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return 'http://localhost:3000/auth/ResetPassword?token=' . $token . '&email=' . $user->email;
        });

        // VerifyEmail::createUrlUsing(function ($notifiable,$url) {
        //     $frontendUrl = 'http://localhost:3000/auth/VerifyEmail';

        //     // $verifyUrl = URL::temporarySignedRoute(
        //     //     'verification.verify',
        //     //     Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
        //     //     [
        //     //         'id' => $notifiable->getKey(),
        //     //         'hash' => sha1($notifiable->getEmailForVerification()),
        //     //     ]
        //     // );
        //     // $verificationUrl = $this->verificationUrl($notifiable);

        //     return $frontendUrl  . $verifyUrl;
        // });


        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {

            $after_verify = substr($url, strpos($url, 'verify/') + 7);
            // Extract the number before the next forward slash using strstr() function
            $id = strstr($after_verify, '/', true);
            // Extract the string between the number and '?' using strpos() and substr() functions
            $hash = substr($after_verify, strpos($after_verify, '/') + 1, strpos($after_verify, '?') - strpos($after_verify, '/') - 1);
            $url_parts = parse_url($url);

            // Extract the 'expires' and 'signature' query parameters using parse_str() function
            parse_str($url_parts['query'], $query_params);
            $expires = $query_params['expires'];
            $signature = $query_params['signature'];

            $newurl = 'http://localhost:3000/auth/VerifyEmail?id=' . $id . '&hash=' . $hash . '&expires=' . $expires . '&signature=' . $signature;
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $newurl);
        });
    }
}
