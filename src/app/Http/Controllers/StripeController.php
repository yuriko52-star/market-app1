<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Item;

class StripeController extends Controller
{
   public function checkout(Request $request)
   {
    $request->validate([
            'item_id' => 'required|exists:items,id',
            'payment_method' => 'required|in:card,konbini',
            'shipping_address' => 'required',
            'shipping_post_code' => 'required',
        ]);
    Stripe::setApiKey(config('services.stripe.secret'));

    $item = Item::findOrFail($request->item_id);
    $paymentMethod =$request->input('payment_method');

    $sessionData = [
            'payment_method_types' => [$paymentMethod],
            'line_items' => [[
            'price_data' => [
                'currency' => 'JPY',
                'product_data' => ['name' => $item->name],
                'unit_amount' => $item->price,
                ],
            'quantity' => 1,
        ]],
        'mode'=> 'payment',
        'success_url' => route('stripe.success',[
            'status' => $paymentMethod === 'konbini' ? 'pending' : 'success',
            'payment_method' => $paymentMethod 
        ]),
        'cancel_url' => route('stripe.cancel'),
        ];

        if ($paymentMethod === 'konbini') 
        {
            $sessionData['payment_method_options'] = [
            'konbini' => []
            ];
        }

    $session = Session::create($sessionData);
    return redirect($session->url);
    } 

    public function success()
   {

    return view('success');
   }

   public function cancel()
   {
    return view('cancel');
   }
}
