<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request) 
    {
        $userId = Auth::id();

        if ($request->query('tab') == 'mylist' && Auth::check()) {
        $items = Auth::user()->likedItems; // ユーザーが「いいね」したアイテムのみ取得
    } else {
        // ログインユーザーの出品アイテムを除外（未ログイン時はすべて取得）
        if ($userId) {
            $items = Item::select('id', 'name', 'img_url')->where('user_id', '!=', $userId)->get();
        } else {
            $items = Item::select('id', 'name', 'img_url')->get();
        }
    }

    return view('list', compact('items'));
}



       /* if ($userId) {
             $items = Item::select('id','name','img_url')->where('user_id','!=',$userId)->get();
        } else {
            
        $items = Item::select('id','name','img_url')->get();
        }

        return view ('list',compact('items'));
        */
    
    public function search (Request $request)
     {
        $keyword = $request->input('keyword');

        $items = Item::where('name', 'LIKE', "%{$keyword}%")->get();

        return view('list', compact('items'));
     }

    

    public function show($itemId) 
    {   $item = Item::with(['categories','condition'])->FindOrFail($itemId);

       
       
        return view('detail',compact('item'));
    } 
}
