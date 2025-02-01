@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="top-content">
        <nav>
            <ul>
                <li><a href="" class="page-title">おすすめ</a></li>
                <li><a href="" class="page-title my-list">マイリスト</a></li>
            </ul>
        </nav>
    </div>

    <div class="under-content">
        <div class="image-card-group">
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
</div>
@endsection