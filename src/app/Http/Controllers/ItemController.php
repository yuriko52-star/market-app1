<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request) 
    {
        $userId = Auth::id();

        if ($request->query('tab') == 'mylist') {

         if (Auth::check()) {
        $items = Auth::user()->likedItems; // ユーザーが「いいね」したアイテムのみ取得
    } else {
        // ログインユーザーの出品アイテムを除外（未ログイン時はすべて取得）
        $items = collect();
        }
    } else {
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

    

    public function show(Item $item ) 
    {   $item->load(['categories','condition']);

       
       
        return view('detail',compact('item'));
    } 
    public function sellPage()
    {
      $user = Auth::user();
      return view('sell');

    }
    public function create()
    {
        //  dd(Category::all()); // デバッグ用

        $user = auth()->user();
        $item = new Item();
        $categories = Category::all();
        $conditions = Condition::all();
        $condition_id = null; 
        return view('sell',compact('user','item','categories','conditions','condition_id'));
    }
    public function store(ExhibitionRequest $request)
    {   
        if (!auth()->check()) {
    return redirect()->route('login');
        }
        //  $user = auth()->user();
        //  $item->user_id = $user->id; 
         $user_id = auth()->id();
        $item = new Item();
        $item->user_id = $user_id;
        $item->name = $request->input('name');
        $item->brand_name = $request->input('brand_name');
        $item->price = $request->input('price');
        $item->description = $request->input('description');
        $item->condition_id = $request->input('condition_id');

         if ($request->hasFile('img_url') && $request->file('img_url')->isValid()) {
        $filename = uniqid() . '_' . $request->file('img_url')->getClientOriginalName();
        $request->file('img_url')->storeAs('public/images', $filename);
        $item->img_url = "/storage/images/$filename";

        // dd($item->img_url);
    } 
        $item->save();
        if($request->has('category_ids')) {
            $item->categories()->attach($request->input('category_ids'));
        }
        return redirect()->route('mypage',['tab' => 'sell']);
    }
}
