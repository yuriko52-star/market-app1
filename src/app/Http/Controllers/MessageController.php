<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{   
    
    public function update(Request $request ,Message $message)
    {
        if ($message->user_id !== auth()->id()) {
            abort(403, '権限がありません');
        }
        $request->validate([
            'body' => 'required|string|max:400',
        ]);
        $message->update([
            'body' => $request->body,
        ]);
        return redirect()->route('chat.index', $message->purchase_id);
    }

    public function destroy(Message $message)
    {
        if($message->user_id !== auth()->id()) {
            abort(403);
        }
        $message->delete();
        return redirect()->route('chat.index', $message->purchase_id);
    } 
}
