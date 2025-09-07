@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}" class="">
@endsection

@section('content')
<div class="content">
    <h1>住所の変更</h1>
        <form action="{{ route('purchase.address.update',['item_id' => $item_id]) }}" method="post">
        @csrf
    <label for="" >
        <h2 class="label-title">郵便番号</h2>
    </label>
    <input type="text" name="shipping_post_code" class="text" value="{{ old('shipping_post_code', $purchase->shipping_post_code ?? '') }}">
   
    <label for="" >
        <h2 class="label-title">住所</h2>
    </label>
    <input type="text" name="shipping_address" class="text" value="{{old('shipping_address', $purchase->shipping_address ?? '') }}">
    
    <label for="" >
        <h2 class="label-title">建物名</h2>
    </label>
    <input type="text" name="shipping_building" class="text" value="{{ old('shipping_building', $purchase->shipping_building ?? '' ) }}">
    
    <div class="">
    <button type="submit" class="update-btn">更新する</button>
    </div>
        </form>
</div>
@endsection