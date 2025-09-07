<?php

namespace App\Http\Controllers;

use App\Mail\TransactionCompletedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Rating;


class RatingController extends Controller
{
    public function store(Request $request, Purchase $purchase)
    {
        $request->validate([
            'rating' => 'required|integer| min:0|max:5',
        ]);
        // 評価した人
        $fromUserId = auth()->id();

        // 相手（to_user_id）を判定
        $toUserId = $purchase->buyer->id === $fromUserId
        ? $purchase->seller->id   : $purchase->buyer->id;   

        Rating::create([
        
            'purchase_id' => $purchase->id,
            'from_user_id' => $fromUserId,
            'to_user_id' => $toUserId,
            'rating'     => $request->rating,
        ]);

    
        $buyerRated = Rating::where('purchase_id', $purchase->id)
            ->where('from_user_id', $purchase->buyer->id)
            ->exists();

        $sellerRated = Rating::where('purchase_id', $purchase->id)
            ->where('from_user_id', $purchase->seller->id)
            ->exists();

            if ($buyerRated && $sellerRated) {
                $purchase->update(['status' => 'completed']);
            } else {
        // もし購入者が評価した直後なら出品者に通知メールを送信
                if($fromUserId === $purchase->buyer->id) {

                    $purchase->load('buyer', 'seller', 'item');
                    Mail::to($purchase->seller->email)
                    ->send(new TransactionCompletedMail($purchase));
                }
            }

        return redirect()->route('list')->with('success','評価を送信しました');
    }
}
