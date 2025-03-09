@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" class="">
@endsection

@section('content')
<div class="content">
    <div class="top-content">
        
            
    <div class="image-file">
        
            <img src="{{ asset($user->profile->img_url) }}" alt="" class="profile_img">
            
       
        <label class="top-title">{{$user->name}}</label>
        <a href="{{ route('profile.edit' ,Auth::user()->id) }} " class="update-btn">プロフィールを編集</a>
        
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
                 
            
                <img src="{{ asset($buyItem->img_url) }}" alt="" class="image">
                
       
            <label for="" class="image-card-name">{{$buyItem->name}}</label>
            </div>
            @endforeach
        @endif
        @if($tab==='sell')
            @foreach($items as $sellItem)
            <div class="image-card">
                 
           
                <img src="{{ asset($sellItem->img_url) }}" alt="" class="image">
                
       
            <label for="" class="image-card-name">{{$sellItem->name}}</label>
            </div>
            @endforeach
        @endif

        
           
    </div>
</div>
@endsection
