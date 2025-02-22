<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest; 
use App\Http\Requests\AddressRequest; 
use App\Models\Profile;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



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
    /*public function storeProfileAddress(Request $request) 
    {$profile = Profile::firstOrCreate(
        ['user_id' => Auth::id()], // 条件
        ['post_code' => '', 'address' => '', 'building' => '', 'img_url' => ''] // 初期値
    );
        // $profile = Profile::where('user_id', Auth::id())->first();


      // $profile = new Profile();
      // $profile->user_id = Auth::id();
      $profile->post_code = $request->post_code;
      $profile->address = $request->address;
      $profile->building = $request->building;
      $profile->save();

     return redirect()->route('list');
    }
    

    public function storeProfileImage(Request $request) 
    {   \Log::info('storeProfileImage メソッドが実行されました');

    //  dd($request->all());
        $profile = Profile::where('user_id', Auth::id())->first();
        if ($request->hasFile('img_url') && $request->file('img_url')->isValid()) {
          $filename = uniqid() . '_' . $request->file('img_url')->getClientOriginalName();
          $request->file('img_url')->storeAs('images', $filename,'public');
          $profile->img_url = $filename;
        } 
        $profile->save();
        return redirect()->route('list');
    }
    */
    public function store(ProfileRequest $profileRequest, AddressRequest $addressRequest) 
    {
      $profile = new Profile();
      $profile->user_id = Auth::id();
      $profile->post_code  = $addressRequest->post_code;
      $profile->address = $addressRequest->address;
      $profile->building = $addressRequest->building;

      if ($profileRequest->hasFile('img_url') && $profileRequest->file('img_url')->isValid()) {
        $filename = uniqid() . '_' . $profileRequest->file('img_url')->getClientOriginalName();
        $profileRequest->file('img_url')->storeAs('public/images', $filename);
        $profile->img_url = "/storage/images/$filename";
    } 
        $profile->save();
     return redirect()->route('list');
    }
    /*public function index()
     {
      $user = Auth::user();
      return view('mypage');
    }
      */


    public function show(Request $request) 
    {
       $user = Auth::user();
      
        $tab = $request->query('tab');
        

          $items = collect();
      if($tab === 'buy')
      {
        
         $items = $user->buyItems()->get();
      }elseif($tab === 'sell') {
        $items = $user->sellItems()->get();
      }
    //  dd($tab,$items);
      return view('mypage',compact('user','items','tab'));
    }
  public function edit(User $user)
  {
    //  $user = auth()->user();
    return view('profile',compact('user'));
  }
  
  public function update(ProfileRequest $profileRequest,AddressRequest $addressRequest ,User $user)
  {
    $validated = array_merge(
      $profileRequest->validated(),
      $addressRequest->validated()
    );

    if($profileRequest->hasFile('img_url') && $profileRequest->file('img_url')->isValid()) {
      if ($user->profile && $user->profile->img_url) {
        Storage::delete(str_replace('/storage','public/',$user->profile->img_url));
      }
      $filename = uniqid() .'_' . $profileRequest->file('img_url')->getClientOriginalName();

      $profileRequest->file('img_url')->storeAs('public/images',$filename);

      $validated['img_url'] = "/storage/images/$filename";

    }
    $user->profile->update($validated);
    return redirect()->route('profile.edit' ,$user->id);
    
  }

}
