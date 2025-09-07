<?php

namespace App\Http\Controllers;
use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registerd;

class RegisterController extends Controller
{
    public function showRegister()
      {
            return view ('auth.register');
      }
    public function processRegister (Request $request, CreateNewUser $createNewUser) 
    {
      $user = $createNewUser->create($request->all());

      Auth::login($user);
      Session::put('user_id', $user->id);
    return redirect('/email/verify');
    }
}
