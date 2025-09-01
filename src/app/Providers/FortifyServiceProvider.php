<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
// use App\Actions\Fortify\ResetUserPassword;
// use App\Actions\Fortify\UpdateUserPassword;
// use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\View;
use Laravel\Fortify\Contracts\VerifyEmailViewResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        
        /* RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
        */
        Fortify::registerView(function () {
         return view('auth.register');
        });

        Fortify::verifyEmailView(function () {
        return view('auth.verify-email');
        });

        $this->app->singleton(
        VerifyEmailViewResponse::class,
        function () {
            return response()->view('auth.verify-email');
        }
        );
         Fortify::loginView(function () { 
            return view('auth.login'); 
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
            return null;
        });


        Fortify::redirects('login', function ($request) {
              return route('list'); // 認証後は常にトップページ
        });
            // $user = $request->user();
            /*if($user->email_verified_at !== null) {
                 return route('list');
            }
            return route('verification.notice');
        });
        */

        RateLimiter::for('login', function (Request $request) {
             $email = (string) $request->email;

           return Limit::perMinute(10)->by($email . $request->ip());
        });   
         $this->app->bind(FortifyLoginRequest::class, LoginRequest::class);
    }





    
}
