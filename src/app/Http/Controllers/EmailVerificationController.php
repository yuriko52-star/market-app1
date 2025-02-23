<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    // メール認証のリクエストを表示
    public function show()
    {
        return view('auth.verify-email');
    }

    // メール認証処理
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        // return redirect('/mypage')->with('status', 'Email verified!');
        return redirect()->route('profile.show')->with('status', 'Email verified!');
    }

    // 認証メールの再送信
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            // return redirect('/mypage');
          return redirect()->route('profile.show');  
        }

        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification email resent!');
    }
}
