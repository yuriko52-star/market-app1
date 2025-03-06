@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/list.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="top-content">
        <nav>
            <ul>
                 {{--<li><a href="{{ route('list') }}" class="page-title">おすすめ</a></li>
               <li><a href="{{ route('list', ['tab' => 'mylist']) }}" class="page-title my-list">マイリスト</a></li>--}}
                <li>
                   <a href="{{ route('list', ['tab' => 'recommend', 'keyword' => session('search_keyword')]) }}" class="page-title">おすすめ</a>
 
                </li>
                <li>
                    @if(session('search_keyword'))
                    <a href="{{ route('list.search', ['tab' => 'mylist', 'keyword' => session('search_keyword')]) }}" class="page-title my-list">マイリスト</a>

                        {{--<a href="{{ route('list.search', ['tab' => 'mylist']) }}?keyword={{ session('search_keyword') }}" class="page-title my-list">マイリスト</a>
                            --}}
                    @else
                        <a href="{{ route('list', ['tab' => 'mylist']) }}" class="page-title my-list">マイリスト</a>
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
                @if($item->isSold())
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