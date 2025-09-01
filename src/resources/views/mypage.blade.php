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
        <button class="star-btn">
            <img src="{{ asset('images/Star 4.png')}}" alt="" class="star">
            <img src="{{ asset('images/Star 4.png')}}" alt="" class="star">
            <img src="{{ asset('images/Star 4.png')}}" alt="" class="star">
            <img src="{{ asset('images/Star 4.png')}}" alt="" class="star">
            <img src="{{ asset('images/Star 4.png')}}" alt="" class="star">
        </button>
        <nav>
            <ul>
                 <li>
                    <a href="{{ route('mypage', ['tab' => 'sell']) }}"  class="sell-items {{ $tab == 'sell' ? 'active-tab' : '' }}">出品した商品</a></li>
                <li>
                    <a href="{{ route('mypage', ['tab' => 'buy']) }}"  class="buy-items {{ $tab == 'buy' ?  'active-tab' : '' }}  ">購入した商品</a>
                    
                </li>
                <li> 
                    <a href="{{ route('mypage',['tab' => 'transaction']) }}" class="transactions {{ $tab == 'transaction' ? 'active-tab' : '' }}">取引中の商品<span class="count">2</span></a> 
                    <!-- 後で修正 -->
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

        @if($tab=== 'transaction')
            @foreach($items as $transaction)
                <div class="image-card">
                    {{--a href="{{route('chat.index', $transaction->id) }}">--}}
                    <a href=""><img src="{{ asset($transaction->img_url) }}" alt="" class="image"></a>
               
                {{-- 未読件数バッジを表示する想定（後でMessageモデルと連携） --}}
                    {{--@if(isset($transaction->unread_count) && $transaction->unread_count > 0)
                        <span class="badge">{{ $transaction->unread_count }}</span>
                    @endif--}}
                    <label class="image-card-name">{{ $transaction->name }}</label>
                 </div>
            @endforeach
        @endif
           
    </div>
</div>
@endsection
