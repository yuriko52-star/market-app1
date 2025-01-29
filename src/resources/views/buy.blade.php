@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/buy.css') }}">
@endsection

@section('content')
 <form action="" class="">
<div class="all-contents">
    <!-- <form action="" class=""> -->
    <div class="left-content">
        <div class="item">
            <div class="image-card">
             <img src="" alt="" class="item-img">
             <p class="img">商品画像</p>
             </div>
            <div class="item-info">
             <label for="" class="item-name">商品名</label>
             <p class="item-price">￥47,000</p>
             </div>
        </div>
        <div class="pay-method">
        <label for="" class="label-title">支払い方法</label>
        <div class="select-inner">
          <select class="select" name="" id="">
            <option disabled selected>選択してください</option>
           
            <option value="">
                
                コンビニ払い</option>
            <option value="">
               
                カード支払い</option>
           
          </select>
        </div>
        </div>
        <div class="shipping-info">
         <div class="flex">
            <label for="" class="label-title">配送先</label>
            <a href="" class="link">変更する</a>
         </div>
         <p class="address">〒xxx-yyyy</p>
         <p class="address">ここには住所と建物が入ります</p>
        </div>
    </div>

    <div class="right-content">
        <!-- 修整しよう -->
        <table>
            <div class="table__inner">
            <tr>
                <th>商品代金</th>
                <td>￥47,000</td>
            </tr>
            <tr>
                <th>支払い方法</th>
                <td>コンビニ払い</td>
            </tr>
            </div>
        </table>
        

        <div class="buy-btn">
            <button class="button" type="submit">購入する</button>
        </div>
    </div>
    <!-- </form> -->
</div>
</form>
@endsection