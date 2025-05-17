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
            $tab = $request->query('tab','recommend');
            $search = $request->query('search');
            // if ($tab == 'mylist' && Auth::check()) {
                if ($tab == 'mylist') {
                    if (Auth::check()) {
                // マイリスト: いいねした商品
                    $items = Auth::user()->likedItems()->with('purchase');
    
                    if ($search) {
                    $items = $items->where('name', 'LIKE', "%{$search}%")->with('purchase');
                    // } else {
                    // $items = $items->with('purchase');
                    }
                    $items = $items->get();
                } else {
                    $items = collect();
                } 
            }else {
                 // おすすめ: 全商品表示
                $items = Item::select('id', 'name', 'img_url')
                ->with('purchase');
    
                if ($userId) {
        // ログインユーザーは自分の商品を除外
                $items = $items->where('user_id', '!=', $userId);
                }
            // }
                // おすすめ: 自分が出品していない商品
                /*$items = Item::select('id', 'name', 'img_url')
                    ->when($userId, function ($query) use ($userId) {
                        return $query->where('user_id', '!=', $userId);
                    })
                    ->with('purchase');
            */
                if ($search) {
                    $items = $items->where('name', 'LIKE', "%{$search}%")->with('purchase');
                //  } else {
                }
                    // $items = $items->with('purchase');
                //  }
                    $items = $items->get();
            }
    
               /* if ($tab == 'mylist') {
     
              if (Auth::check()) {
               
                  $items = Auth::user()->likedItems()->with('purchase' )
                 ->get(); 
         } else {
              $items = collect();
            }
         } else {
             if ($userId) {
                $items = Item::select('id', 'name', 'img_url')
                  ->where('user_id', '!=', $userId)
                  ->with('purchase')
                  ->get();   
             } else {
                  $items = Item::select('id', 'name', 'img_url')
                  ->with('purchase')
                 ->get();
             }
         }
             */

        return view('list', compact('items', 'tab', 'search'));
     }
     
     public function search (Request $request)
     {
        
        $keyword = $request->input('keyword');
    // session()->put('search_keyword', $keyword);
        // $items = Item::where('name', 'LIKE', "%{$keyword}%")->get();
        // $tab = 'search';
        // return view('list', compact('items', 'tab'));
        return redirect()->route('list', ['tab' => 'recommend', 'search' => $keyword]);
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
        

        $user = auth()->user();
        $item = new Item();
        $categories = Category::all();
        $conditions = Condition::all();
        $condition_id = null; 
        return view('sell',compact('user','item','categories','conditions','condition_id'));
    }
    public function store(ExhibitionRequest $request)
    {   
        $user = auth()->user();

    
    
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

        
    } 
        $item->save();
        if($request->has('category_ids')) {
            $item->categories()->attach($request->input('category_ids'));
        }
        return redirect()->route('mypage',['tab' => 'sell']);
    }
}
