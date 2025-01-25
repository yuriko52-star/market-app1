@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}" class="">
@endsection

@section('content')
<div class="content">
    <h1>住所の変更</h1>
    <form action="" class="">
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