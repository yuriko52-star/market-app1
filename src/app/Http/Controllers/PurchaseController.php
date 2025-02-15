<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show($item_id)
{
    $user = auth()->user();
    $item = Item::findOrFail($item_id);
    $profile = $user->profile;
    $purchase = $user->purchases()->where('item_id', $item_id)->first();

    return view('buy', [
        'item' => $item,
        //  'purchase' => $purchase,
        'shipping_address' => $purchase->shipping_address ?? $profile->address ?? '',
        'shipping_post_code' => $purchase->shipping_post_code ?? $profile->post_code ?? '',
        'shipping_building' => $purchase->shipping_building ?? $profile->building ?? '',
        'payment_methods' => ['クレジットカード支払い', 'コンビニ決済']
    ]);
}
    /*public function show($item_id)
    {
        $user= auth()->user();
        $item = Item::findOrFail($item_id);
        $profile = $user->profile;
        
         $shipping_address = $profile ?$profile->address : null;
         $shipping_post_code = $profile ? $profile->post_code : null;
         $shipping_building = $profile ? $profile->building : null;

         return view('buy', [
        'item' => $item,
        'shipping_address' => $shipping_address,
        'shipping_post_code' => $shipping_post_code,
        'shipping_building' => $shipping_building,
        'payment_methods' => ['クレジットカード支払い',  'コンビニ決済']
    ]);
    }
        
    /*public function buy(Request $request ,$item_id) 
    {
        return view('buy',['item_id'=> $item_id]);
    }
        */
    /*   public function store(Request $request)
{
    // バリデーション
    /*$request->validate([
        'payment_method' => 'required|string|in:コンビニ払い,カード支払い'
    ]);
    
     Purchase::create([
            'user_id' => Auth::id(),
            'payment_method' => $request->input('payment_method')
        ]);
    // 選択された支払い方法をセッションに保存
   
    return redirect()->back();
    */
    public function editAddress($item_id)
    {
    $user = auth()->user();
    $purchase = Purchase::where('user_id', $user->id)->where('item_id', $item_id)->first();

    return view('address', [
        'item_id' => $item_id,
         'shipping_address' => $purchase ? $purchase->shipping_address : $user->profile->address,
        'shipping_post_code' => $purchase ? $purchase->shipping_post_code : $user->profile->post_code,
        'shipping_building' => $purchase ? $purchase->shipping_building : $user->profile->building,
        ]);
    }

    public function updateAddress(Request $request, $item_id)
    {
    // $user = auth()->user();

    // バリデーション
    /*$request->validate([
        'shipping_address' => 'required|string|max:255',
        'shipping_post_code' => 'required|string|max:10',
        'shipping_building' => 'nullable|string|max:255',
    ]);
    */
    $user = auth()->user();
    // `purchases` テーブルに該当データがあるか確認
    $purchase = $user->purchases()->where('item_id', $item_id)->first();

    if ($purchase) {
        // すでに購入データがある場合は更新
        $purchase->update([
            'shipping_address' => $request->input('shipping_address'),
            'shipping_post_code' => $request->input('shipping_post_code'),
            'shipping_building' => $request->input('shipping_building'),
        ]);
    } else {
        // 購入データがない場合は新規作成
        $user->purchases()->create([
            // 'user_id' => $user->id,
            'item_id' => $item_id,
            'shipping_address' => $request->input('shipping_address'),
            'shipping_post_code' => $request->input('shipping_post_code'),
            'shipping_building' => $request->input('shipping_building'),
            'payment_method' => '',
        ]);
    }

    return redirect()->route('purchase.show', ['item_id' => $item_id])->with('purchase',$purchase);
    // return view('buy',['item_id' => $item_id]);
}
    
public function store(Request $request) 
{
    Purchase::create([
        'user_id' => auth()->id(),
        'item_id' =>$request->item_id,
        'payment_method'=> $request->payment_method,
        'shipping_address' =>$request->shipping_address,
        'shipping_post_code' =>$request->shipping_post_code,
        'shipping_builrding'=>$request->shipping_building,

    ]);
    return redirect('/');
}




}

 

