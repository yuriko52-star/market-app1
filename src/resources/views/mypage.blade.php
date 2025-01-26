@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" class="">
@endsection

@section('content')
<div class="content">
    <div class="top-content">
         <form action="" class="">
    <div class="image-file">
        <input type="text"  class="text-image">
        <!-- <div id="previewArea"> -->
            <img src="" alt="" class="">
            
        <!-- </div> -->
        <label class="top-title">ユーザー名</label>
        <button class="update-btn" type="submit">プロフィールを編集
        </button>
    </div>
        <nav>
            <ul>
                <li><a href="" class="sell-items">出品した商品</a></li>
                <li><a href="" class="buy-items">購入した商品</a></li>
            </ul>
        </nav>
    </div>

    <div class="under-content">
        
        <div class="image-card">
            <a href="" class="image-card-link">
                <img src="" alt="" class="image">
                <p>商品画像</p>
            </a>
       
            <label for="" class="image-card-name">商品名</label>
        </div>
        
        <div class="image-card">
            <a href="" class="image-card-link">
                <img src="" alt="" class="image">
                 <p>商品画像</p>
            </a>
            <label for="" class="image-card-name">商品名</label>
        </div>
        <div class="image-card">
            <a href="" class="image-card-link">
                <img src="" alt="" class="image">
                 <p>商品画像</p>
            </a>
            <label for="" class="image-card-name">商品名</label>
        </div>
        <div class="image-card">
            <a href="" class="image-card-link">
                <img src="" alt="" class="image">
                 <p>商品画像</p>
            </a>
            <label for="" class="image-card-name">商品名</label>
        </div>
        <div class="image-card">
            <a href="" class="image-card-link">
                <img src="" alt="" class="image">
                 <p>商品画像</p>
            </a>
            <label for="" class="image-card-name">商品名</label>
        </div>
        <div class="image-card">
            <a href="" class="image-card-link">
                <img src="" alt="" class="image">
                 <p>商品画像</p>
            </a>
            <label for="" class="image-card-name">商品名</label>
        </div>
        <div class="image-card">
            <a href="" class="image-card-link">
                <img src="" alt="" class="image">
                 <p>商品画像</p>
            </a>
            <label for="" class="image-card-name">商品名</label>
        </div>

    </div>
</div>
@endsection
