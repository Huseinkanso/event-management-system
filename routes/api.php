<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentReplyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\TicketController;
use App\Http\Resources\SpeakerResource;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

//  integrate payment gateway on frontend
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/payment', [PaymentController::class, 'index']);
    Route::get('/ticket', [TicketController::class, 'index']);
    Route::post('/payment/{event}', [PaymentController::class, 'pay']);
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::get('/me', function () {
        $data = null;
        $user = auth()->user();
        if ($user->type == 1) {
            return response(['user' => new SpeakerResource($user->speaker)]);
        }
        return response(['user' => new UserResource($user)]);
    });
    Route::get('/speakers', [SpeakerController::class, 'index']);
    Route::get('speakerInfo/{user}', [SpeakerController::class, 'speakerInfo']);
    // Route::apiResource('user',UserController::class);
    Route::patch('/updateSpeakerInfo/{speaker}', [SpeakerController::class, 'update']);
    Route::post('/addComment', [CommentReplyController::class, 'storeComment']);
    Route::post('/addReply', [CommentReplyController::class, 'storeReply']);
    Route::get('/{event}/comments', [CommentReplyController::class, 'getEventComments']);
    Route::delete('/delete-reply/{reply}', [CommentReplyController::class, 'deleteReply']);
    Route::delete('/delete-comment/{comment}', [CommentReplyController::class, 'deleteComment']);
    // events
    Route::get('/myEvents', [EventController::class, 'myEvents']);
    Route::get('/event/categories', [EventController::class, 'getCategories']);
    Route::get('/event/category/{category}', [EventController::class, 'getEventsByCategory']);
    Route::get('/event/{event}/info', [EventController::class, 'getEventInfo']);
    Route::get('/event/time/{time}', [EventController::class, 'getEventsByTime']);
    Route::get('event/all', [EventController::class, 'all']);
    Route::get('event/speaker/{searchKey}', [EventController::class, 'speakerEventSearch']);
    Route::get('/event/search/{searchKey}', [EventController::class, 'search']);
    Route::apiResource('event', EventController::class);

});

Route::group(['namespace' => 'Auth'], function () {

    // auth routes
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/speakerRegister', [RegisterController::class, 'speakerRegister']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'applyResetPassword'])->name('password.email');
    Route::get('/reset-password/{token}')->name('password.reset');

    // login with github
    Route::post('/login/github/callback', [LoginController::class, 'callBackGithub']);
    Route::get('/login/github', [LoginController::class, 'githubTargetUrl']);

    // register with google
    // Route::post('/register/google/callback',[LoginController::class,'callBackGoogle']);
    // Route::get('/register/google',[LoginController::class,'googleTargetUrlTargetUrl']);

    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response(['notify' => 'email verified successfully']);
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {

    $request->user()->sendEmailVerificationNotification();

    return response(['notify' => 'Verification link sent!']);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
