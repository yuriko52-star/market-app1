<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PurchaseRequest;

class StripeController extends Controller
{
   public function checkout(PurchaseRequest $request)
   {
    Stripe::setApiKey(config('services.stripe.secret'));
    
    $user = auth()->user();
     $item = Item::findOrFail($request->item_id);
    
    $paymentMethod = $request->input('payment_method');  
    $purchase = Purchase::updateOrCreate(
        ['user_id' => $user->id, 'item_id' => $item->id],
        [
            'payment_method' => $paymentMethod,
            'shipping_address' => session('shipping_address'),
            'shipping_post_code' => session('shipping_post_code'),
            'shipping_building' => session('shipping_building'),
            'status' => 'paid',
            
        ]
    );
   

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
            
            'item_id' => $item->id,
            'payment_method' => $paymentMethod 
        ]),
        'cancel_url' => route('stripe.cancel'),
        ];
        

        $session = Session::create($sessionData);
        return redirect($session->url);
    } 

    public function success(Request $request)
   {
    
    $user = auth()->user();
    $item_id = $request->query('item_id');
     $payment_method = $request->query('payment_method');
    
    $purchase = Purchase::where('user_id', $user->id)
            ->where('item_id', $item_id)
            ->first();
    $purchase->save();

        return view('success');
   }

   public function cancel()
   {
    return view('cancel');
   }
}
