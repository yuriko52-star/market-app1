@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="content">
    <h1>プロフィール設定</h1>
    <form action="" class="">
    <div class="image-file">
        <input type="file" id="fileInput" style="display: none;" accept="image/*">
        <div id="previewArea">
            <img src="" alt="" class="">
            <!-- アップロード用にstyleを追加する -->
        </div>
        <label for="fileInput" class="image-btn">画像を選択する
    </label>
    
    </div>

    <label for="" >
        <h2 class="label-title">ユーザー名</h2>
    </label>
    <input type="text" class="text">
    <label for="" >
        <h2 class="label-title">郵便番号</h2>
    </label>
    <input type="text" class="text">
    <label for="" >
        <h2 class="label-title">住所</h2>
    </label>
    <input type="text" class="text">
    <label for="" >
        <h2 class="label-title">建物名</h2>
    </label>
    <input type="text" class="text">
    <div class="">
    <button class="update-btn">更新する</button>
    </div>
    </form>
    
</div>
@endsection