<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    
    public function show()
    {
        return view('auth.verify-email');
    }

    
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        $user = $request->user();
       
        if(!$user->profile) {
        return redirect()->route('profile.show')->with('status', 'Email verified!');
    }
    return redirect()->route('list')->with('status', 'Email verified!');
}
    
    public function resend(Request $request)
    {
        $user = $request->user();
        
        $user->sendEmailVerificationNotification();
        return back()->with('message', 'Verification email resent!');
    }
}

