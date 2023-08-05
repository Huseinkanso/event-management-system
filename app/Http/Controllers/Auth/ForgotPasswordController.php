<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
class ForgotPasswordController extends Controller
{
    public function applyResetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        // back()->with(['status' => __($status)])
        // back()->withErrors(['email' => __($status)]);
        return $status === Password::RESET_LINK_SENT
            ? response(['notify'=>'you will recieve a reset password link in an email soon.'])
            : response(['status'=>$status],Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        // redirect()->route('login')->with('status', __($status))
        // back()->withErrors(['email' => [__($status)]]);
        return $status === Password::PASSWORD_RESET
                    ? response(['status'=>'password reset successfully'])
                    : response(['status'=>'not done'.$status],Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    // public function submitResetPasswordForm(Request $request)
    //   {
    //       $request->validate([
    //           'email' => 'required|email|exists:users',
    //           'password' => 'required|confirmed',
    //           'token'=>'required'
    //       ]);

    //       $updatePassword = DB::table('password_reset_tokens')
    //                           ->where([
    //                             'email' => $request->email,
    //                             'token' => $request->token
    //                           ])
    //                           ->first();

    //       if(!$updatePassword){
    //           return response(['message','invalid token']);
    //       }

    //       $user = User::where('email', $request->email)
    //                   ->update(['password' => Hash::make($request->password)]);

    //       DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

    //       return response(['message','Your password has been changed']);
    //   }

}
