@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="top-content">
        <nav>
            <ul>
                
                <li>
                  
                    <a href="{{ route('list',['tab' => 'recommend']) }}" class="page-title {{ $tab == 'recommend' ? 'active-tab': '' }}">おすすめ</a>
                    <li>
                    @if(Auth::check())
                    <a href="{{ route('list', ['tab' => 'mylist']) }}" class="page-title {{$tab == 'mylist' ? 'active-tab' : '' }}">マイリスト</a>
                    @endif
   
                </li>
            </ul>
        </nav>
    </div>

    <div class="under-content">
        <div class="image-card-group">
            @foreach($items as $item)
            <div class="image-card">
                <a href="{{ route('item.show', ['item' =>$item->id]) }}" class="image-card-link">
                <img src="{{ asset($item->img_url) }}" alt="" class="image">
                @if($item->purchase)
                    <p>Sold</p>
                @endif
                </a>
       
            <label for="" class="image-card-name">{{$item->name}}</label>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection