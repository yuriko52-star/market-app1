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
        if (!$user) {
        return redirect()->route('login');
    }

    
    if (!$user->hasVerifiedEmail()) {
        return redirect()->route('verification.notice');
    }
        $payment_method = session('payment_method');
        $shipping_address = session('shipping_address', $user->profile->address);
        $shipping_post_code = session('shipping_post_code', $user->profile->post_code);
        $shipping_building = session('shipping_building', $user->profile->building);
        // $user = auth()->user();
        $item = Item::findOrFail($item_id);
        /* $profile = $user->profile ?? (object) [
            'address' => '',
            'post_code' => '',
            'building' => '',
        ];
        */
        // これを追加
        // $payment_method = session('payment_method', '');
        // $purchase = $user->purchases()->where('item_id', $item_id)->first();


        /*return view('buy', [
            'item' => $item,
            'shipping_address' => $purchase->shipping_address ?? $profile->address ?? '',
            'shipping_post_code' => $purchase->shipping_post_code ?? $profile->post_code ?? '',
            'shipping_building' => $purchase->shipping_building ?? $profile->building ?? '',
            'payment_method' => $purchase->payment_method ?? '',
            'payment_methods' => ['カード支払い', 'コンビニ支払い']
        ]);
        */
        return view('buy', [
            'item' => $item,
            'shipping_address' => $shipping_address,
            'shipping_post_code' => $shipping_post_code,
            'shipping_building' => $shipping_building,
            'payment_method' => $payment_method,
        ]);
    }

    public function selectPayment(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'payment_method' => 'required|in:card,konbini'
        ]);
        // $user = auth()->user();
    
        // $item_id = $request->input('item_id');
        // これも追加
        // $payment_method = $request->input('payment_method');

        
        // $purchase = $user->purchases()->where('item_id',$item_id)->first();
 
        /*if($purchase) {
            $purchase->update([
                'payment_method' => $payment_method,
                'isPaid' => false // 常に未決済として保存
            ]);
        } else {
            $purchase = $user->purchases()->create([
                'item_id' => $item_id,
                'payment_method' => $payment_method,
                'shipping_address' => $user->profile->address,
                'shipping_post_code' => $user->profile->post_code,
                'shipping_building' => $user->profile->building,
                 'isPaid' => false,
            ]);
        }
            */
            session (['payment_method' => $request->input('payment_method')]);
            return redirect()->route('purchase.show', ['item_id' => $request->input('item_id') ]);

    }
    
    public function editAddress($item_id)
    {
        $user = auth()->user();
        // $purchase = Purchase::where('user_id', $user->id)->where('item_id', $item_id)->first();
        $shipping_address = session('shipping_address', $user->profile->address);
        $shipping_post_code = session('shipping_post_code', $user->profile->post_code);
        $shipping_building = session('shipping_building', $user->profile->building);

        /*return view('address', [
            'item_id' => $item_id,
            'shipping_address' => $purchase ? $purchase->shipping_address : $user->profile->address,
            'shipping_post_code' => $purchase ? $purchase->shipping_post_code : $user->profile->post_code,
            'shipping_building' => $purchase ? $purchase->shipping_building : $user->profile->building,
            ]);
            */
            return view('address', [
                'item_id' => $item_id,
                'shipping_address' => $shipping_address,
                'shipping_post_code' => $shipping_post_code,
                'shipping_building' => $shipping_building,
            ]);
    }

    public function updateAddress(Request $request, $item_id)
    {
        // $user = auth()->user();
        // $purchase = $user->purchases()->where('item_id', $item_id)->first();
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_post_code' => 'required|string',
            'shipping_building' => 'required|string',
        ]);
        /*if ($purchase) {
            $purchase->update([
                'shipping_address' => $request->input('shipping_address'),
                'shipping_post_code' => $request->input('shipping_post_code'),
                'shipping_building' => $request->input('shipping_building'),
            
            ]);
            } else {
        
            $user->purchases()->create([
            
                'item_id' => $item_id,
                'shipping_address' => $request->input('shipping_address'),
                'shipping_post_code' => $request->input('shipping_post_code'),
                'shipping_building' => $request->input('shipping_building'),
                'payment_method' => 'konbini',
            ]);
            $updatedPurchase = $user->purchases()->where('item_id', $item_id)->first();
        }
            */
             // 住所情報をセッションに保存
    session([
        'shipping_address' => $request->input('shipping_address'),
        'shipping_post_code' => $request->input('shipping_post_code'),
        'shipping_building' => $request->input('shipping_building'),
    ]);
       
         return redirect()->route('purchase.show', ['item_id' => $item_id]);
        
    }
    
   /* public function store(PurchaseRequest $request) 
    {
        $user = auth()->user(); 
        $item_id = $request->input('item_id');
        $payment_method = $request->input('payment_method');
        if (empty($payment_method)) {
        return redirect()->back()->withErrors(['payment_method' => 'エラー: 支払い方法を選択してください。']);
        }
    
        $shipping_address = !empty($request->shipping_address) ? $request->shipping_address : $user->profile->address;
        $shipping_post_code = !empty($request->shipping_post_code) ? $request->shipping_post_code : $user->profile->post_code;
        $shipping_building = !empty($request->shipping_building) ? $request->shipping_building : $user->profile->building;

    
        $purchase = $user->purchases()->where('item_id', $request->item_id)->first();
        if ($purchase) {
    
            $purchase->update([
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address ?: $user->profile->address,
                'shipping_post_code' => $request->shipping_post_code ?: $user->profile->post_code,
                'shipping_building' => $request->shipping_building ?: $user->profile->building,
            ]);
            } else {
            Purchase::create([
                'user_id' => auth()->id(),
                'item_id' => $item_id, 
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->shipping_address ?: $user->profile->address,
                'shipping_post_code' => $request->shipping_post_code ?: $user->profile->post_code,
                'shipping_building' => $request->shipping_building ?: $user->profile->building,
            ]);
        }
    
            return redirect()->route('stripe.checkout',['item_id' => $item_id]);
    }
            */
}