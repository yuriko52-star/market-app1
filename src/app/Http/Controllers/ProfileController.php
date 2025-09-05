<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest; 
use App\Http\Requests\AddressRequest; 
use App\Models\Profile;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class ProfileController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth','verified']);
  }
    public function showProfile() {
         $user = Auth::user();
           $profile = $user->profile ?? null; 
    
       return view('profile',compact('user','profile'));
    }
    
    public function create() {
      $profile = new Profile();
      $profile->user_id = Auth::id();
      return view('profile.create',compact('profile'));
    
    }
   
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
    

    
    public function show(Request $request) 
    {
       $user = Auth::user();
      
        	$tab = $request->query('tab');
        
         $items = collect();
        //  $items = collect();
      
        	if ($tab === 'buy') {
			// 購入した商品（履歴）	
          	$items = $user->purchases()
				->where('status', 'completed')
				->with('item')
				->get()
        // こちらが最新
        ->map(function($purchase) {
            $purchase->unread_count = $purchase->messages()
                ->where('user_id', '!=', auth()->id())
                ->where('is_read', false)
                ->count();
            return $purchase;
        });
				// ->map(fn($purchase) => $purchase->item);
          // 9/5外した

      	}elseif ($tab === 'sell') 
		// 出品中の商品
      	{
        	$items = $user->sellItems()->get();

      	} elseif ($tab === 'transaction') {

			// 取引中（購入者 or 出品者の両方を考慮）

			$items = Purchase::where(function($q) use ($user) {
				// 自分が購入者
				$q->where('user_id', $user->id);
			})
			->orWhereHas('item', function($q) use ($user) {
				// 自分が出品者
				$q->where('user_id', $user->id);
			})
			->where('status', 'paid')
      // 下から書き換え
      ->with('item', 'messages')
        ->get()
        ->map(function($purchase) use ($user) {
            $purchase->unread_count = $purchase->messages
                ->where('user_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();
            return $purchase;
        })
         ->sortByDesc(fn($purchase) => optional($purchase->messages->first())->created_at);
			// 取引中のステータス
			// ->with('item')
			//未読数バッジの計算 最初はこちら
			
			// のちに今のコードに差し替え
			/*->with(['item', 'messages' => function($q) use($user) {
				$q->where('user_id', '!=', 		     $user->id) 
				// 自分以外が送ったメッセージ
				->where('is_read', false);
				// 　未読のみ
				// ->latest();
		}]) 
			->get()
      ->map(function($purchase) {
                // unread_count を追加
                $purchase->unread_count = $purchase->messages->count();
                return $purchase;

			 /*->map(fn($purchase) => $purchase->item)
			->sortByDesc(function($purchase) {
				$item = $purchase->item;
				$item->unread_count = $purchase->messages->count();
				return optional($purchase->messages->first())->created_at;
        こちらは9/5上のコードに書き換えた*
				})
        ->sortByDesc(fn($purchase) => optional($purchase->messages->first())->created_at);
        */
		}
		
		

      return view('mypage',compact('user','items','tab'));
    }

      public function edit($userId)
    {
      $user = User::find($userId);
   
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
   
    if (!$user->profile) {
        $user->profile()->create($validated);
    } else {
        $user->profile->update($validated);
    }

    return redirect()->route('profile.edit' ,$user->id);
  }
    

}
