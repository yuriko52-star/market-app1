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
        ? $purchase->seller->id   // 評価者が購入者なら相手は出品者
        : $purchase->buyer->id;   // 評価者が出品者なら相手は購入者

    // すでに評価済みなら更新
    // Rating::updateOrCreate(
    Rating::create([
        // [
            'purchase_id' => $purchase->id,
            'from_user_id' => $fromUserId,
        // ],
        // [
            'to_user_id' => $toUserId,
            'rating'     => $request->rating,
        ]);

    // 両者が評価済みか確認.もしエラーが出たら書き換える
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
            Mail::to($purchase->seller->email)
            ->send(new TransactionCompletedMail($purchase));
        }
    }


        return redirect()->route('list')->with('success','評価を送信しました');
    }
}
