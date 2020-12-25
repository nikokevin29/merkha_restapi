<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;

class VerificationController extends Controller
{
    use VerifiesEmails;
    protected $redirectTo = '/home';
    public function __construct()
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware('signed')->only('verify');
        //[throttle] limit request 6 times for 1 minutes
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {

            return response(['message'=>'Already verified']);
        }

        $request->user()->sendEmailVerificationNotification();

        if ($request->wantsJson()) {
            return response(['message' => 'Email Sent']);
        }

        return back()->with('resent', true);
    }
    public function verify(Request $request)
    {
        auth()->loginUsingId($request->route('id'));

        if ($request->route('id') != $request->user()->getKey()) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {

            return response(['message'=>'Already verified']);

            // return redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return response(['message'=>'Successfully verified']);

    }
    // public function verify(Request $request) {
    //     // if (!$request->hasValidSignature()) {
    //     //     return response()->json(["messeage" => "Invalid / expired url provided."], 401);
    //     // }

    //     $user = User::find($request->route('id'));

    //     if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
    //         throw new AuthorizationException;
    //     }

    //     if ($user->markEmailAsVerified())
    //         event(new Verified($user));

    //     return redirect($this->redirectPath())->with('verified', true);
    //     // $user = User::findOrFail($user_id);
    
    //     // if (!$user->hasVerifiedEmail()) {
    //     //     $user->markEmailAsVerified();
    //     // }
        
    //     //return ResponseFormatter::success($user,'Verify Success And Email Sent to '.$user->email);
    // }
    
    // public function resend() {
    //     if (Auth::user()->hasVerifiedEmail()) {
    //         return response()->json(["messeage" => "Email already verified."], 400);
    //     }
        
    //     // $request->user()->sendEmailVerificationNotification();
    
    //     return response()->json(["messeage" => "Email verification link sent on your email id"]);
    // }
}
