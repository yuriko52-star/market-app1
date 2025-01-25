@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}" class="">
@endsection

@section('content')
<!-- <div class="container"> -->
    <!-- あとでつけるかも -->
    <div class="content">
    <h1>ログイン</h1>
    <form action="" class="">
    <label for="" >
        <h2 class="label-title">ユーザー名 / メールアドレス</h2>
    </label>
    <input type="text" class="text">
    <label for="" >
        <h2 class="label-title">パスワード</h2>
    </label>
    <input type="text" class="text">
    <div class="">
    <button class="login-btn">ログインする</button>
    </div>
    </form>
    <a href="" class="link">会員登録はこちら</a>
    </div>
<!-- </div> -->
 <!-- あとでつけるかも -->
@endsection