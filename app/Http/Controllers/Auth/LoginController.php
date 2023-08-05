<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\SpeakerResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\Cookie;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token=$user->createToken('authToken')->plainTextToken;
        return response()->json([
            'token' => $token,
            'notify'=>'logged in succesfully',
            'user'=>$user->type==1?new SpeakerResource($user->speaker):new UserResource($user)
        ]);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function callBackGithub()
    {
        $user = Socialite::driver('github')->stateless()->user();
        $email = $user->getEmail();
        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json([
                'token' => $user->createToken('main')->plainTextToken,
                'user' => $user,
                'notify'=>'logged in succesfully with github'
            ]);
        } else {
            return response(['notify'=>'there is something wrong.please try again'], Response::HTTP_CONFLICT);
        }
    }
    public function githubTargetUrl()
    {
        // we put stateless cause our api is  stateless
        // getTargetUrl for returning the url to frontend and redirecting from there cause we work in the frontend
        return response([
            'url' => Socialite::driver('github')->stateless()->redirect()->getTargetUrl()
        ], 200);
    }



    // public function callBackGoogle()
    // {
    //     $user = Socialite::driver('google')->stateless()->user();
    //     $email = $user->getEmail();
    //     $user = User::where('email', $email)->first();
    //     if ($user) {
    //         return response()->json([
    //             'token' => $user->createToken('main')->plainTextToken,
    //             'user' => $user
    //         ]);
    //     } else {
    //         return response(null, Response::HTTP_NOT_FOUND);
    //     }
    // }
    // public function googleTargetUrl()
    // {
    //     // we put stateless cause our api is  stateless
    //     // getTargetUrl for returning the url to frontend and redirecting from there cause we work in the frontend
    //     return response([
    //         'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl()
    //     ], 200);
    // }
}
