@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="all-contents">
    <div class="left-content">
        
        <div class="image-card">
           
             <img src="{{ asset($item->img_url)}}" alt="" class="item-img">
             <!-- <p class="img">商品画像</p> -->
        </div>
    </div>

    <div class="right-content">
        <label for="" class="page-title">
            {{$item->name}}
           
        </label>
        <p class="brand-name">ブランド名</p>
        <!--  -->
        <p class="item-price"><span>￥</span>{{ number_format($item->price) }}<span>（税込）</span>
        </p>
        <div class="flex">
            <form action="" class="">
            <div class="likes">
                <button class="likes-icon" type="submit"><img src="{{ asset('images/星アイコン8.png')}}" alt="" class="likes-img"></button>
                <p class="count">3</p>
            </div>
            </form>
            <div class="comments">
                <img src="{{ asset('images/ふきだしのアイコン.png') }}" alt="" class="comments-img">
                <p class="count">1</p>
            </div>
        </div>
        <form action="" class="">
            <div class="buy-btn">
                <button class="button" type="submit">購入手続きへ</button>
            </div>
        </form>

        <section class="item-info">
            <label for="" class="section-title">商品説明
            </label>
            <p class="description">{{$item->description}}</p>
            
            <!-- <p class="description">新品<br> -->
            <!-- 商品の状態は良好です。傷もありません。</p> -->
            <p class="description">購入後、即発送いたします。</p>

            
        </section>

        <section class="item-info">
            <label for="" class="section-title">商品の情報</label>
            <dl>
                <dt>カテゴリー</dt>
                @foreach($item->categories as $category)
                <dd class="category">{{$category->name}}</dd>
                <!-- <dd class="category">メンズ</dd> -->
                 @endforeach
            </dl>
            <dl>
                <dt>商品の状態</dt>
               
                <dd class="condition">{{$item->condition->content}}</dd>
                
            </dl>
        </section>
        <section class="comments-form">
            <f action="" class="">
                <label for="" class="comment-title">コメント（１）</label>
                <div class="flex">
                    <div class="image-file">
                        <img src="" alt="" class="profile-img">
                    </div>
                        <label for="" class="user-name">admin</label>
                </div>
                <p class="comment-input">こちらにコメントが入ります。</p>
                <label for="" class="label">商品へのコメント</label>
                <textarea name="" class="textarea"></textarea>
                <div class="comments-btn">
                    <button class="button" type="submit">コメントを送信する</button>
                </div>
        </section>
    </div>
</div>
@endsection