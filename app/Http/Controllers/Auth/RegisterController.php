<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\StoreSpeakerRequest;
use App\Mail\WelcomeEmail;
use App\Models\Speaker;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\Account;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    // if function is empty laravel always return 200 (ok)
    public function register(RegisterRequest $request)
    {
        // return $request->all();
        // ->send(new WelcomeEmail([
        //     'name'=>$user->name,
        //     'body'=>'congratulations,your registration is complete'
        // ]));
        $user = User::create($request->all());

        Mail::to($user->email)->queue(new WelcomeEmail([
            'name' => $user->name,
            'body' => 'congratulations,your registration is complete',
        ]));

        // $user->notify(new Registered($user));
        event(new Registered($user));

        return response('created', Response::HTTP_CREATED);
    }
    public function speakerRegister(StoreSpeakerRequest $request)
    {
        // return $request->all();
        // return $request->all();
        // Set the Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a new Stripe account for the speaker
        $account = Account::create([
            'type' => 'express',
            'country' => 'US',
            'email' => $request->email,
        ]);
        DB::beginTransaction();
        try {
            $user = User::create($request->only(['name', 'email', 'password', 'type']));
            $speaker = Speaker::create($request->except('image') + ['user_id' => $user->id, 'stripe_account_id' => $account->id]);
            $speaker->attachImage($request->image);
            DB::commit();
            return response(['notify' => 'registration is complete with new stripe account also'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
        }


    }
}
