<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Purchase $purchase) 
    {
        $messages = $purchase->messages()
            ->with('user.profile')
            ->orderBy('created_at')
            ->get();
// 出品者・購入者・商品をビューに渡す
            $buyer = $purchase->buyer;
            $seller = $purchase->seller;
            $item = $purchase->item;

        return view('chat', compact('purchase', 'messages', 'buyer','seller', 'item'));
    }

    public function store(Request $request ,Purchase  $purchase){
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
