<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
     public function toggleLike(Item $item)
    {
        if (Auth::check()) {
        $user = Auth::user();

        // 「いいね」が既にあるかチェック
        $like = Like::where('user_id', $user->id)
                    ->where('item_id', $item->id)
                    ->first();

        if ($like) {
            // いいね解除
            $like->delete();
        } else {
            // いいね登録
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
        }
    } else {
        // 未ログインユーザーはセッションで管理
        $likes = session()->get('guest_likes', []);
        if (in_array($item->id, $likes)) {
            // いいね解除
            $likes = array_diff($likes, [$item->id]);
        } else {
            // いいね登録
            $likes[] = $item->id;
        }
        session()->put('guest_likes', $likes);
    }

    return redirect()->back();
    }
}

   


