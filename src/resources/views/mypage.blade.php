@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" class="">
@endsection

@section('content')
<div class="content">
    <div class="top-content">
         <form action="" class="">
            
    <div class="image-file">
        <!-- <input type="text"  class="text-image"> -->
        <!-- <div id="previewArea"> -->
            <img src="{{ asset($user->profile->img_url) }}" alt="" class="profile_img">
            
        <!-- </div> -->
        <label class="top-title">{{$user->name}}</label>
        <a href="{{ route('profile.edit' ,$user->id) }} " class="update-btn">プロフィールを編集</a>
        <!-- <button class="update-btn" type="submit"> -->
        <!-- </button> -->
    </div>
  
        <nav>
            <ul>
                 <li>
                    <a href="{{ route('mypage', ['tab' => 'sell']) }}"  class="sell-items">出品した商品</a></li>
                <li>
                    <a href="{{ route('mypage', ['tab' => 'buy']) }}"  class="buy-items">購入した商品</a>
                    
                </li> 
            </ul>
        </nav>
    </div>
    
 
    <div class="under-content">
        <div class="image-card-group">
        @if($tab==='buy')
            @foreach($items as $buyItem)
            <div class="image-card">
                 
            <!-- <a href="" class="image-card-link"> -->
                <img src="{{ asset($buyItem->img_url) }}" alt="" class="image">
                <!-- <p>商品画像</p> -->
            <!-- </a> -->
       
            <label for="" class="image-card-name">{{$buyItem->name}}</label>
            </div>
            @endforeach
        @endif
        @if($tab==='sell')
            @foreach($items as $sellItem)
            <div class="image-card">
                 
            <!-- <a href="" class="image-card-link"> -->
                <img src="{{ asset($sellItem->img_url) }}" alt="" class="image">
                <!-- <p>商品画像</p> -->
            <!-- </a> -->
       
            <label for="" class="image-card-name">{{$sellItem->name}}</label>
            </div>
            @endforeach
        @endif

        
           
    </div>
</div>
@endsection
