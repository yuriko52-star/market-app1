<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function showProfile() {
         $user = Auth::user();

      return view('profile',compact('user'));
    }
    public function create() {
      $profile = new Profile();
      $profile->user_id = Auth::id();
      return view('profile.create',compact('profile'));
    
    }

    public function store(Request $request) 
    {
      $profile = new Profile();
      $profile->user_id = Auth::id();
      $profile->post_code = $request->post_code;
      $profile->address = $request->address;
      $profile->building = $request->building;

      if ($request->hasFile('img_url') && $request->file('img_url')->isValid()) {
        $filename = uniqid() . '_' . $request->file('img_url')->getClientOriginalName();
        $request->file('img_url')->storeAs('images', $filename, 'public');
        $profile->img_url = $filename;
    } 
        $profile->save();
     return redirect()->route('list');
    }

}
