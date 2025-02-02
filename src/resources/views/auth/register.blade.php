@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="content">
    <h1>会員登録</h1>
    <form action="" class="">
    <label for="" >
        <h2 class="label-title">ユーザー名</h2>
    </label>
    <input type="text" class="text">
    <label for="" >
        <h2 class="label-title">メールアドレス</h2>
    </label>
    <input type="text" class="text">
    <label for="" >
        <h2 class="label-title">パスワード</h2>
    </label>
    <input type="text" class="text">
    <label for="" >
        <h2 class="label-title">確認用パスワード</h2>
    </label>
    <input type="text" class="text">
    <div class="">
    <button class="register-btn">登録する</button>
    </div>
    </form>
    <a href="/login" class="link">ログインはこちら</a>
</div>
@endsection