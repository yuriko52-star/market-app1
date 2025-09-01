@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}" class="">
@endsection
<!-- グリッドレイアウトを使用しよう！ -->
@section('content')
<div class="wrapper">
<div class="sidebar">
    <p>その他の取引</p>
</div>


<div class="top-content">
    <img src="" alt="" class="">
    <h1 class="">「ユーザー名」さんとの取引画面</h1>
    <button class="complete-btn">取引を完了する</button>
    <!-- このボタンは出品者にはつかない -->
</div>
<div class="middle-content">
    <img src="" alt="" class="">
    <div class="text">
        <p class="item-name">商品名</p>
        <p class="price">商品価格</p>
    </div>
</div>
<div class="under-content">
    <div class="flex">
        <div class="item">
            <div class="label">
                <img src="" alt="" class="user-img">
                <p>ユーザー名</p>
            </div>
            
                <input type="text" class="input">
            
        </div> 
         <div class="item">     
            <div class="my-label">
                <p>ユーザー名</p>
                <img src="" alt="" class="user-img">
            </div>
                <input type="text" class="input">
            <div class="btns">
                <input type="submit" value="編集" >
                <input type="submit" value="削除">
            </div>
        </div>
         
    </div>
    
            <input type="text" class="message" placeholder="取引メッセージを記入してください">
            <button class="add-btn">画像を追加</button>
            <button class="send-btn">
            <img src="{{ asset('images/inputbuttun 1.png')}}" alt="" class="input-btn">
            </button>
    
</div>

    

</div>
@endsection

<!-- 出品者、購入者で使いまわす -->