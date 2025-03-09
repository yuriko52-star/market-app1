@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}" class="">
@endsection

@section('content')

    <div class="content">
    <h1>ログイン</h1>
    <form action="/login" class="" method="post" novalidate >
        @csrf
    <label for="" >
        <h2 class="label-title">ユーザー名 / メールアドレス</h2>
    </label>
    <input type="email" class="text" name="email" value="{{old('email')}}">
    <div class="form_error">
        @error('email')
        {{ $message}}
        @enderror
    </div>

    <label for="" >
        <h2 class="label-title">パスワード</h2>
    </label>
    <input type="password" class="text" name="password">
    <div class="form_error">
        @error('password')
        {{ $message}}
        @enderror
    </div>
    <div class="">
    <button class="login-btn" type="submit">ログインする</button>
    </div>
    </form>
    <a href="/register" class="link">会員登録はこちら</a>
    </div>

@endsection