@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection
@section('content')
<div class="content">
    <h2>登録していただいたメールアドレスに認証メールを送付しました。</h2>
    <h2>メール認証を完了してください。</h2>
   <a href="" class="verify-btn">
     認証はこちらから
   </a>
   @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    <form action="{{ route('verification.resend') }}" class=""method="post">
        @csrf
        <button class="btn btn-primary" type="submit">認証メールを再送する</button>
    </form> 
</div>
@endsection