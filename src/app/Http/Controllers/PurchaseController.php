<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use App\Models\User;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show($item_id)
{
    $user = auth()->user();
    $item = Item::findOrFail($item_id);
    $profile = $user->profile ?? (object) [
         'address' => '',
        'post_code' => '',
        'building' => '',
    ];
    $purchase = $user->purchases()->where('item_id', $item_id)->first();
// dd($purchase);

    return view('buy', [
        'item' => $item,
        //  'purchase' => $purchase,
        'shipping_address' => $purchase->shipping_address ?? $profile->address ?? '',
        'shipping_post_code' => $purchase->shipping_post_code ?? $profile->post_code ?? '',
        'shipping_building' => $purchase->shipping_building ?? $profile->building ?? '',
        'payment_method' => $purchase->payment_method ?? '',
         'payment_methods' => ['カード支払い', 'コンビニ支払い']
    ]);
}

public function updatePayment(Request $request)
{
    $user = auth()->user();
    
    $item_id = $request->input('item_id');


    if (!$item_id) {
        dd('Error: item_id is missing', $request->all());
    }


    $purchase = $user->purchases()->where('item_id',$request->input('item_id'))->first();
 
    if($purchase) {
        $purchase->update([
            'payment_method' => $request->input('payment_method'),
        ]);
    } else {
        $purchase = $user->purchases()->create([
            'item_id' => $item_id,
            'payment_method' => $request->input('payment_method'),
            'shipping_address' => $user->profile->address,
            'shipping_post_code' => $user->profile->post_code,
            'shipping_building' => $user->profile->building,
        ]);
    }
     return redirect()->route('purchase.show', ['item_id' => $item_id]);

    // return redirect()->route('purchase.show', ['item_id' => $item_id ?? 'missing']);
    // return redirect()->route('purchase.show',['item_id' =>$request->input('item_id')]);
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
    
    $user = auth()->user();
     
    // `purchases` テーブルに該当データがあるか確認
    $purchase = $user->purchases()->where('item_id', $item_id)->first();

    if ($purchase) {
        // すでに購入データがある場合は更新
        $purchase->update([
            'shipping_address' => $request->input('shipping_address'),
            'shipping_post_code' => $request->input('shipping_post_code'),
            'shipping_building' => $request->input('shipping_building'),
            // 'payment_method' => $purchase->payment_method,
        ]);
    } else {
        // 購入データがない場合は新規作成
        $user->purchases()->create([
            // 'user_id' => $user->id,
            'item_id' => $item_id,
            'shipping_address' => $request->input('shipping_address'),
            'shipping_post_code' => $request->input('shipping_post_code'),
            'shipping_building' => $request->input('shipping_building'),
            'payment_method' => 'konbini',
        ]);
        $updatedPurchase = $user->purchases()->where('item_id', $item_id)->first();
    // dd($updatedPurchase); 
    }
     
     return redirect()->route('purchase.show', ['item_id' => $item_id]);
    // return redirect()->route('purchase.show', ['item_id' => $item_id])->with('purchase',$purchase);
    // return redirect()->route('purchase.show', ['item_id' => $item_id])->with('purchase',$purchase);
    // return view('buy',['item_id' => $item_id]);
}
    
    public function store(PurchaseRequest $request) 
{
//  dd('store() メソッドが実行された！', $request->all()); // 🔥 追加
    //  dd($request->all());
    $user = auth()->user(); // ログインユーザーを取得
    $item_id = $request->input('item_id');
     $payment_method = $request->input('payment_method');
      if (empty($payment_method)) {
        return redirect()->back()->withErrors(['payment_method' => 'エラー: 支払い方法を選択してください。']);
    }
    // デフォルトの配送先を `profile` から取得
    $shipping_address = !empty($request->shipping_address) ? $request->shipping_address : $user->profile->address;
    $shipping_post_code = !empty($request->shipping_post_code) ? $request->shipping_post_code : $user->profile->post_code;
    $shipping_building = !empty($request->shipping_building) ? $request->shipping_building : $user->profile->building;

    //   if (empty($item_id)) {
        // dd('Error: item_id is null', $request->all());
    // }
  $purchase = $user->purchases()->where('item_id', $request->item_id)->first();
if ($purchase) {
    //  dd('Updating:', $purchase, $request->all());
        // すでに購入データがある場合は更新
      $purchase->update([
            'payment_method' => $request->payment_method,
            'shipping_address' => $request->shipping_address ?: $user->profile->address,
            'shipping_post_code' => $request->shipping_post_code ?: $user->profile->post_code,
            'shipping_building' => $request->shipping_building ?: $user->profile->building,
        ]);
    } else {
        Purchase::create([
            'user_id' => auth()->id(),
            'item_id' => $item_id, // 🔥 `null` になっていないか確認！
            'payment_method' => $request->payment_method,
            'shipping_address' => $request->shipping_address ?: $user->profile->address,
            'shipping_post_code' => $request->shipping_post_code ?: $user->profile->post_code,
            'shipping_building' => $request->shipping_building ?: $user->profile->building,
        ]);

        // うまくいかなかったらここを直そう！
       /* $purchase->update([
            'payment_method' => $request->payment_method,
            'shipping_address' => !empty($request->shipping_address) ? $request->shipping_address : $user->profile->address,
            'shipping_post_code' => !empty($request->shipping_post_code) ? $request->shipping_post_code : $user->profile->post_code,
            'shipping_building' => !empty($request->shipping_building) ? $request->shipping_building : $user->profile->building,
        ]);

    }else {
        // dd('Creating:', $request->all());
    Purchase::create([
        'user_id' => auth()->id(),
        'item_id' =>$request->item_id,
        'payment_method'=> $request->payment_method,
        'shipping_address' =>$request->shipping_address,
        'shipping_post_code' =>$request->shipping_post_code,
        'shipping_building'=>$request->shipping_building,

    ]);
}
    */
    }
    // return redirect('/');
    return redirect()->route('stripe.checkout',['item_id' => $item_id]);
    
    /*public function buyPage(Request $requet)
    {
          $user = Auth::user();
      
        $tab = $request->query('tab');
        $items = collect();
      if($tab === 'buy')
      {
        /*$items = \DB::table('purchases')
                    ->where('user_id', $user->id)
                    ->join('items', 'purchases.item_id', '=', 'items.id')
                    ->select('items.*')
                    ->get();
                    
         $items = $user->buyItems()->get();
      }
         return view('mypage',compact('user','items','tab'));

    */





}

 

}