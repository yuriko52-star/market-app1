@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/buy.css') }}">
@endsection

@section('content')

<div class="all-contents">
   
    <div class="left-content">
        <div class="item">
            <div class="image-card">
             <img src="{{ asset($item->img_url) }}" alt="" class="item-img">
           
             </div>
            <div class="item-info">
             <label for="" class="item-name">{{ $item->name }}</label>
             <p class="item-price"><span>￥</span>{{number_format($item->price)}}</p>
             </div>
        </div>
    <form action="{{route('purchase.updatePayment') }}" method="post">
    @csrf
        <input type="hidden" name="item_id" value="{{ $item->id}}">
        <div class="pay-method">
        <label for="payment_method" class="label-title">支払い方法</label>
       
        
        <select class="select" name="payment_method" id="payment_method" onchange="this.form.submit()" >
            <option value="" disabled {{ empty(old('payment_method', $payment_method)) ? 'selected' : '' }}>選択してください</option>
            <option value="konbini" {{ old('payment_method', $payment_method) == 'konbini' ? 'selected' : '' }}>コンビニ支払い</option>
            <option value="card" {{ old('payment_method', $payment_method) == 'card' ? 'selected' : '' }}>カード支払い</option>
    </select>
           
       
        <style>
            select:focus option[value=""] {
            display: none;
            }
        </style>
        <p class="form_error">
            @error('payment_method')
            {{$message}}
            @enderror
        </p>
        
        </div>
    </form>
    
    <form action="{{ route('stripe.checkout') }}" method="post"> 
    @csrf
     <input type="hidden" name="item_id" value="{{ $item->id }}">  
      <input type="hidden" name="payment_method" value="{{ $payment_method }}">
        <div class="shipping-info">
            <div class="flex">
            <label for="" class="label-title">配送先</label>
            <a href="{{route('purchase.address',['item_id' => $item->id]) }}" class="link">変更する</a>
            </div>
         <p class="address"><span>〒</span>{{$shipping_post_code}}</p>
         <p class="address">{{$shipping_address}}</p>
         <p class="address">{{$shipping_building}}</p>
            <input type="hidden" name="shipping_address" value="{{ $shipping_address }}">
            <input type="hidden" name="shipping_post_code" value="{{ $shipping_post_code }}">
            <input type="hidden" name="shipping_building" value="{{ $shipping_building }}">
        </div>
    </div>

    <div class="right-content">
        
        <table>
            
            <tr>
                <th>商品代金</th>
                <td>￥{{number_format($item->price)}}</td>
            </tr>
            <tr>
                <th>支払い方法</th>
                <td>
                    @if($payment_method == 'card')
                        カード支払い
                    @elseif($payment_method == 'konbini')
                        コンビニ支払い
                    @else
                        未選択
                    @endif
                </td>
                
            </tr>
            
        </table>
        

        <div class="buy-btn">
            <button class="button" type="submit">購入する</button>
        </div>
    </div>
    
</div>
</form>
@endsection