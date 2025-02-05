@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="content">
    <h1>プロフィール設定</h1>
    <form action="{{ route('profile.store') }}" class="" method="post" enctype="multipart/form-data">
        @csrf
    <div class="image-file">
        <input type="file" id="fileInput" style="display: none;" accept="image/*" name="img_url">
        <div id="previewArea">
            <img src="" alt="" class="">
           
        </div>
        <label for="fileInput" class="image-btn">画像を選択する
        </label>
     </div>
        <p class="form_error">
            @error('img_url')
            {{ $message}}
            @enderror
        </p>
   
   
    
    
    <label for="" >
        <h2 class="label-title">ユーザー名</h2>
    </label>
    <input type="text" class="text" name="name" value="{{ old('name', $user->name) }}">
    <p class="form_error">
        @error('name')
        {{ $message}}
        @enderror
    </p>
    <label for="" >
        <h2 class="label-title">郵便番号</h2>
    </label>
    <input type="text" class="text" name="post_code" value="{{ old('post_code') }}">
    <p class="form_error">
        @error('post_code')
        {{ $message}}
        @enderror
    </p>
    <label for="" >
        <h2 class="label-title">住所</h2>
    </label>
    <input type="text" class="text" name="address" value="{{ old('address') }}">
    <p class="form_error">
        @error('address')
        {{ $message}}
        @enderror
    </p>
    <label for="" >
        <h2 class="label-title">建物名</h2>
    </label>
    <input type="text" class="text" name="building" value="{{ old('building') }}">
    <p class="form_error">
        @error('building')
        {{ $message}}
        @enderror
    </p>
    <div class="">
    <button class="update-btn">更新する</button>
    </div>
    </form>
    
</div>
@endsection