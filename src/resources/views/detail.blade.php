@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="all-contents">
   
    <div class="left-content">
      
        <div class="image-card">
           
             <img src="{{ asset($item->img_url)}}" alt="" class="item-img">
            
        </div>
    </div>

    <div class="right-content">
        <label for="" class="page-title">
            {{$item->name}}
        </label>
        <p class="brand-name">{{$item->brand_name}}</p>
       
        <p class="item-price"><span>￥</span>{{ number_format($item->price) }}<span>（税込）</span>
        </p>
        <div class="flex">
            <div class="likes">
       @php
        $liked = false;
        $likeCount = $item->likedUsers()->count();

        if (session()->has('guest_likes')) {
        $guestLikes = session('guest_likes');
        if (in_array($item->id, $guestLikes)) {
            $liked = true;  
        }
        $likeCount += count($guestLikes); 
        }
        if (Auth::check()) {
        $liked = \App\Models\Like::where('user_id', Auth::id())->where('item_id', $item->id)->exists();
        }
        @endphp
        <form action="{{ route('toggle-like', ['item' => $item->id]) }}" method="POST">
        @csrf
            <button class="likes-icon" type="submit">
                <div class="likes-img-wrapper">
                    <img src="{{ asset('images/星アイコン8.png')}}" alt="" class="likes-img ">
                    <div class="likes-overlay {{ $liked ? 'liked' : '' }}">
                </div>
                   
            </button>
        </form> 
        <p class="count">{{ $likeCount }}</p>
            </div>
            
            <div class="comments">
                <img src="{{ asset('images/ふきだしのアイコン.png') }}" alt="" class="comments-img">
                <p class="count">{{ $item->comments->count()}}</p>
            </div>
        </div>
        <form action="{{ route('purchase.show',['item_id' => $item->id]) }}" class=""method="get">
            
            <div class="buy-btn">
                <button class="button" type="submit">購入手続きへ</button>
            </div>
        </form>

        <section class="item-info">
            <label for="" class="section-title">商品説明
            </label>
            <p class="description">{{$item->description}}</p>
            <p class="description">購入後、即発送いたします。</p>
        </section>

        <section class="item-info">
            <label for="" class="section-title">商品の情報</label>
            <dl>
                <dt>カテゴリー</dt>
                @foreach($item->categories as $category)
                <dd class="category">{{$category->name}}</dd>
                @endforeach
            </dl>
            <dl>
                <dt>商品の状態</dt>
              
                <dd class="condition">{{$item->condition->content }}</dd>
                
            </dl>
        </section>
        <section class="comments-form">
            
            
            <form action="{{ route('comment.store',['item_id' => $item->id]) }}" class="" method="post">
                @csrf
                <label for="" class="comment-title">コメント({{ $item->comments->count()}} )</label>
                @foreach($item->comments as $comment)
                <div class="flex">
                  
                    <div class="image-file">
                       <img src="{{ asset($comment->user->profile->img_url) }}" alt="" class="profile-img">
                    
                    </div>
                        <label for="" class="user-name">{{$comment->user->name}}</label>
                </div>
                <p class="comment-input">{{ $comment->comment}}</p>
               
                @endforeach
                <label for="" class="label">商品へのコメント</label>
                <textarea name="comment" class="textarea"></textarea>
                 <p class="form_error">
                    @error('comment')
                    {{$message}}
                    @enderror
                </p>
                <div class="comments-btn">
                    <button class="button" type="submit">コメントを送信する</button>
                </div>
                
            </form>
        </section>
    </div>
</div>
@endsection