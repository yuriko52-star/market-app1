<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
   public function checkout(Request $request)
   {
    Stripe::setApiKey(config('services.stripe.secret'));
    /*$request->validate([
            'item_id' => 'required|exists:items,id',
            'payment_method' => 'required|in:card,konbini',
            'shipping_address' => 'required',
            'shipping_post_code' => 'required',
        ]);
    */
    $user = auth()->user();
     $item = Item::findOrFail($request->item_id);
     $paymentMethod = session('payment_method');
    $purchase = Purchase::updateOrCreate(
        ['user_id' => $user->id, 'item_id' => $item->id],
        [
            'payment_method' => $paymentMethod,
            'shipping_address' => session('shipping_address'),
            'shipping_post_code' => session('shipping_post_code'),
            'shipping_building' => session('shipping_building'),
            
        ]
    );
   
// Stripe チェックアウトセッションを作成
   $sessionData = [
             'payment_method_types' => [$paymentMethod],
            // 'payment_method_types' => ['card', 'konbini'],
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
            // 'status' => $paymentMethod === 'konbini' ? 'pending' : 'success',
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
    //  Log::info("Success メソッド - User ID: {$user->id}, Item ID: {$item_id}, Payment Method: {$payment_method}");
    $purchase = Purchase::where('user_id', $user->id)
            ->where('item_id', $item_id)
            ->first();

        /*if ($purchase) {
            if ($payment_method === 'konbini') {
            $purchase->update(['isPaid' => true, 'status' => 'pending']);
            Log::info("コンビニ決済 - isPaid を true に更新（支払い待ち) ");
         } else {
            $purchase->update(['isPaid' => true]);
            Log::info("カード決済 - isPaid を true に更新");
         }
        }else {
            Log::warning("購入データが見つかりません - isPaid を更新できません");
        }
        */
        
        $purchase->save();

        return view('success');
   }

   public function cancel()
   {
    return view('cancel');
   }
}
