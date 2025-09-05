<?php

namespace App\Http\Controllers;

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
        
        $toUserId = $purchase->buyer->id === $fromUserId
        ? $purchase->seller->id   // 評価者が購入者なら相手は出品者
        : $purchase->buyer->id;   // 評価者が出品者なら相手は購入者

    // すでに評価済みなら更新
    Rating::updateOrCreate(
        [
            'purchase_id' => $purchase->id,
            'from_user_id' => $fromUserId,
        ],
        [
            'to_user_id' => $toUserId,
            'rating'     => $request->rating,
        ]
    );

    // 両者が評価済みか確認
    $buyerRated = Rating::where('purchase_id', $purchase->id)
        ->where('from_user_id', $purchase->buyer->id)
        ->exists();

    $sellerRated = Rating::where('purchase_id', $purchase->id)
        ->where('from_user_id', $purchase->seller->id)
        ->exists();

    if ($buyerRated && $sellerRated) {
        $purchase->update(['status' => 'completed']);
    }


        return redirect()->route('list')->with('success','評価を送信しました');
    }
}
