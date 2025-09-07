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
    Log::info("Webhook エントリーポイント");
    Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        // シークレットキーの検証
        try {
            \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $secret
            );
            Log::info("Webhook シークレット検証成功");
        } catch (\Exception $e) {
            Log::error("Webhook シークレット検証エラー: " . $e->getMessage());
            return response()->json(['error' => 'Invalid Webhook'], 400);
        }

        // $event = $payload['type'] ?? '';
        $event = json_decode($payload, true);
        $eventType = $event['type'] ?? '不明';
        Log::info("Stripe Webhook 受信: " . $eventType);

        if ($eventType === 'checkout.session.completed') {
            $session = $event['data']['object'];

            $user_id = $session['metadata']['user_id'] ?? null;
            $item_id = $session['metadata']['item_id'] ?? null;

            if ($user_id && $item_id) {
                $purchase = Purchase::where('user_id', $user_id)
                                    ->where('item_id', $item_id)
                                    ->first();

                if($purchase) {
                    $purchase->update(['isPaid' => true]);
                    Log::info("支払い完了: 注文 ID: {$purchase->id}");
                } else {
                    Log::warning("購入データが見つかりません: user_id = {$user_id}, item_id = {$item_id}");
                }
            } else {
                Log::error("Webhook で user_id または item_id が見つかりません");
            }
        }

        return response()->json(['status' => 'success'], 200);
    }



    
}
