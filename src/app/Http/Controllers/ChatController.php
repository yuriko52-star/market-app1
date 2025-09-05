<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ChatRequest; 

class ChatController extends Controller
{
    public function index(Purchase $purchase) 
    {
        $user = auth()->user();
        // 相手の未読メッセージを既読にする
    $purchase->messages()
        ->where('user_id', '!=', $user->id)
        ->where('is_read', false)
        ->update(['is_read' => true]);

        // メッセージ取得
        $messages = $purchase->messages()
            ->with('user.profile')
            ->orderBy('created_at')
            ->get();
// 出品者・購入者・商品をビューに渡す
            $buyer = $purchase->buyer;
            $seller = $purchase->seller;
            $item = $purchase->item;

            // 自分が出品者かどうか
    $isSeller = ($user->id === $seller->id);

        return view('chat', compact('purchase', 'messages', 'buyer','seller', 'item', 'isSeller'));
    }

    public function store(ChatRequest $request ,Purchase  $purchase){
        $request->validate([
            'body' => 'required|string',
        ]);
        // あとでフォームリクエストを作成する
        Message::create([
            'purchase_id' => $purchase->id,
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);
        return redirect()->route('chat.index', $purchase->id);
    }
    
}
