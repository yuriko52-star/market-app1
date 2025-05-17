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
        $item = Item::findOrFail($item_id);
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
        
        session (['payment_method' => $request->input('payment_method')]);
            return redirect()->route('purchase.show', ['item_id' => $request->input('item_id') ]);

    }
    
    public function editAddress($item_id)
    {
        $user = auth()->user();
        
        $shipping_address = session('shipping_address', $user->profile->address);
        $shipping_post_code = session('shipping_post_code', $user->profile->post_code);
        $shipping_building = session('shipping_building', $user->profile->building);

        
            return view('address', [
                'item_id' => $item_id,
                'shipping_address' => $shipping_address,
                'shipping_post_code' => $shipping_post_code,
                'shipping_building' => $shipping_building,
            ]);
    }

    public function updateAddress(Request $request, $item_id)
    {
        
        $request->validate([
            'shipping_address' => 'required|string',
            'shipping_post_code' => 'required|string',
            'shipping_building' => 'required|string',
        ]);
        
             // 住所情報をセッションに保存
    session([
        'shipping_address' => $request->input('shipping_address'),
        'shipping_post_code' => $request->input('shipping_post_code'),
        'shipping_building' => $request->input('shipping_building'),
    ]);
       
         return redirect()->route('purchase.show', ['item_id' => $item_id]);
        
    }
    
   
}