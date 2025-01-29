@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="content">
    <h1 class="page-title">商品の出品</h1>
    <form action="" class="sell-form">
      <div class="image-file">
        <label for="" class="label">商品画像</label>
        <input type="file" id="fileInput" style="display: none;" accept="image/*">
            <div id="previewArea">
                <img src="" alt="" class="">
            <!-- アップロード用にstyleを追加する -->
        
            <label for="fileInput" class="image-btn">画像を選択する</label>
            </div>
      </div>
        
        <section class="detail">
            <h2 class="section-title">商品の詳細</h2>
            <label class="label">カテゴリー</label>
            <div class="button-container">
                <button class="category-button">ファッション</button>
                <button class="category-button">家電</button>
                <button class="category-button">インテリア</button>
                <button class="category-button">レディース</button>
                <button class="category-button">メンズ</button>
                <button class="category-button">コスメ</button>
                <button class="category-button">本</button>
                <button class="category-button">ゲーム</button>
                <button class="category-button">スポーツ</button>
                <button class="category-button">キッチン</button>
                <button class="category-button">ハンドメイド</button>
                <button class="category-button">アクセサリー</button>
                <button class="category-button">おもちゃ</button>
                <button class="category-button">ベビー・キッズ</button>
               
            </div>
            <label for="" class="label">商品の状態</label>
            <div class="select-inner">
                <select class="select" name="" id="">
                <option disabled selected class="default">選択してください</option>
           
                <option value="">良好</option>
                <option value="">目立った傷や汚れなし</option>
                <option value="">やや傷や汚れあり</option>
                <option value="">状態が悪い</option>
                </select>
            </div>
        <!-- </div> -->
            
        </section>

        <section class="description">
            <h2 class="section-title">商品名と説明</h2>
            <label for="" class="label">商品名</label>
            <div class="text-input">
            <input type="text" class="input">
            </div>
            <label class="label">商品の説明</label>
            <textarea name="" class="textarea"></textarea>
            <label for="" class="label">販売価格</label>
            <div class="text-input">
            <input type="text" class="input" value="￥">
            </div>
        </section>
        <div class="button">
            <button class="sell-button" type="submit">出品する</button>
        </div>
    </form>

</div>

@endsection