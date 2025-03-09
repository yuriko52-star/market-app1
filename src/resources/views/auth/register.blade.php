@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="content">
    <h1>会員登録</h1>
    <form action="{{ route('register.process') }}" class="" method="post" novalidate>
        @csrf
    <label for="" >
        <h2 class="label-title">ユーザー名</h2>
    </label>
    <input type="text" class="text" name="name" value="{{ old('name') }}">
    <p class="form_error">
        @error('name')
        {{ $message }}
        @enderror
    </p>
    <label for="" >
        <h2 class="label-title">メールアドレス</h2>
    </label>
    <input type="text" name="email" class="text" value="{{ old('email') }}">
    <p class="form_error">
        @error('email')
        {{ $message }}
        @enderror
    </p>
    <label for="" >
        <h2 class="label-title">パスワード</h2>
    </label>
    <input type="password"  name="password" class="text">
    <p class="form_error">
        @error('password')
        {{ $message }}
        @enderror
    </p>
    <label for="" >
        <h2 class="label-title">確認用パスワード</h2>
    </label>
    
    <input type="password" name="password_confirmation" class="text" >
          <p class="form_error">
           @error('password')
           {{ $message}}
           @enderror
          </p>
           <p class="form_error">
           @error('password_confirnation')
           {{ $message}}
           @enderror
          </p>
        <div>
        <button class="register-btn" type="submit">登録する</button>
        </div>
    </form>
    <a href="/login" class="link">ログインはこちら</a>
</div>
@endsection