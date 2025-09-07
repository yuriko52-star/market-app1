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
    <p class="stars">
        @for($i = 1; $i <=5; $i++)
            @if($i <= round($user->averageRating()))
                <img src="{{ asset('images/Star 1.png')}}" alt="" class="star">
            @else
                <img src="{{ asset('images/Star 4.png') }}" alt="" class="star">
            @endif
        @endfor

    </p>
        <nav>
            <ul>
                 <li>
                    <a href="{{ route('mypage', ['tab' => 'sell']) }}"  class="sell-items {{ $tab == 'sell' ? 'active-tab' : '' }}">出品した商品</a></li>
                <li>
                    <a href="{{ route('mypage', ['tab' => 'buy']) }}"  class="buy-items {{ $tab == 'buy' ?  'active-tab' : '' }}  ">購入した商品</a>
                    
                </li>
                <li> 
                    <a href="{{ route('mypage',['tab' => 'transaction']) }}" class="transactions {{ $tab == 'transaction' ? 'active-tab' : '' }}">取引中の商品
                        @if($items->sum('unread_count') > 0)
                        <span class="count">{{ $items->sum('unread_count') }}</span>
                        @endif
                    </a> 
                   
                </li>
            </ul>
        </nav>
    </div>
    
 
    <div class="under-content">
        <div class="image-card-group">
        @if($tab==='buy')
            @foreach($items as $purchase)
                <div class="image-card">
                    <img src="{{ asset($purchase->item->img_url) }}" alt="" class="image">
                    <label for="" class="image-card-name">{{$purchase->item->name}}</label>
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
        @if($tab==='transaction')
            @foreach($items as $purchase)
            <div class="image-card">
                <a href="{{ route('chat.index', $purchase->id) }}">
                    <img src="{{ asset($purchase->item->img_url) }}" alt="" class="image">
                    @if($purchase->unread_count > 0)
                        <span class="badge">{{ $purchase->unread_count }}</span>
                    @endif
                </a>
                <label class="image-card-name">{{ $purchase->item->name }}</label>
            </div>
            @endforeach
        @endif
           
    </div>
</div>
@endsection
