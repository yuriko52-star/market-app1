<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Webhook;
use App\Models\Purchase;

class StripeWebhookController extends Controller
{
  public function handleWebhook(Request $request)  
  {
    Stripe::setApiKey(config('services.stripe.secret'));

    $payload = $request->all();
    $event = $payload['type'] ?? '';

    Log::info("Stripe Webhook 受信: " . $event);

    if ($event === 'checkout.session.completed') {
        $session = $payload['data']['object'];

        $purchase = Purchase::where('stripe_session_id',$session['id'])->first();
        if($purchase) {
            $purchase->update(['status'=> 'paid']);
            Log::info("支払い完了: 注文 ID: {$purchase->id}");
        }
    }
    return response()->json(['status' => 'success']);
  }
}
