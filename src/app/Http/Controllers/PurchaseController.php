<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $user= auth()->user();
        $item = Item::findOrFail($item_id);
        $profile = $user->profile;

        $shipping_address = $profile->address;
        $shipping_post_code = $profile->post_code;
        $shipping_building = $profile->building;

        return view('buy',[
            'item' => $item,
            'profile' => $profile,
            'shipping_address' => $shipping_address,
            'shipping_post_code' =>$shipping_post_code,
            'shipping_building' => $shipping_building,
            'payment_methods' => [ 'コンビニ払い','カード支払い']
        ]);
    }
    /*public function buy(Request $request ,$item_id) 
    {
        return view('buy',['item_id'=> $item_id]);
    }
        */
}
