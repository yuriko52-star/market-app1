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

        
        $like = Like::where('user_id', $user->id)
                    ->where('item_id', $item->id)
                    ->first();

        if ($like) {
            
            $like->delete();
        } else {
            
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
        }
           
    } else {
        
        $likes = session()->get('guest_likes', []);
        if (in_array($item->id, $likes)) {
            
            $likes = array_diff($likes, [$item->id]);
        } else {
            
            $likes[] = $item->id;
        }
        session()->put('guest_likes', $likes);
    }

    return redirect()->back();
    }
}

   


