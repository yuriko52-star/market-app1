@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}" class="">
@endsection

@section('content')
<div class="wrapper">
    <div class="sidebar">
        <p>その他の取引</p>
    </div>


    <div class="top-content">
        @if(auth()->id() === $buyer->id)
          <!-- 自分が購入者なので、相手は出品者  -->
            <img src="{{ asset($seller->profile->img_url) }}" alt="" class="">
        @else
        <!-- 自分が出品者なので、相手は購入者  -->
            <img src="{{ asset($buyer->profile->img_url) }}" alt="" class="">
        @endif
        <h1 class="">「
            @if(auth()->id() === $buyer->id)
                {{ $seller->name }}
            @else
                {{ $buyer->name}}
            @endif
                」さんとの取引画面</h1>
        @if(auth()->id() === $buyer->id)
        <!-- 購入者だけ表示 -->
        <form action="" class="">
            @csrf
            <button class="complete-btn">取引を完了する</button>
        </form>
        @endif
    </div>
    <!-- top-content -->
    <div class="middle-content">
        <img src="{{ asset($item->img_url) }}" alt="" class="">
        <div class="text">
            <p class="item-name">{{ $item->name }}</p>
            <p class="price">{{ number_format($item->price) }}円</p>
        </div>
    </div>
<!-- middle-content -->
    <div class="under-content">
        <div class="flex">
    @foreach($messages as $message) 
        @if($message->user_id === auth()->id())
            {{-- 自分（右側） --}}
            
        <div class="item my-message">
            <div class="message-wrapper">
                <div class="my-label">
                    {{-- 自分の名前と画像 --}}
                    <p>{{ auth()->user()->name }}</p>
                    <img src="{{ asset(auth()->user()->profile->img_url) }}" alt="" class="user-img">
                </div>
                {{-- 通常表示 --}}
                <p class="my-message-body" id="message-{{ $message->id }}">{{ $message->body }}</p>
               
             {{-- 編集フォーム --}}
                <form action="{{route('messages.update', $message->id)}}" method="post" class="edit-form" id="form-{{ $message->id }}" style="display:none;">
                    @csrf 
                    @method('PUT')
                    <input type="text"name="body" value="{{$message->body}}"class=".edit-input" >
                </form>
              
                 
                <div class="btns">
                    <button type="button" class="edit-btn" data-id="{{ $message->id }}">
                        編集
                    </button>
                    <!-- </form> -->
                
                    <form method="POST" action="{{ route('messages.destroy', $message->id) }}">
                        @csrf
                        @method('DELETE')
                    <button type="submit">削除</button>   
                    </form>
                </div>
            </div>
        </div>
        @else
            {{-- 相手（左側） --}}
            <div class="item other-message">
                <div class="other-message-wrapper">
                <div class="other-label">
                    {{-- 相手の名前と画像 --}}
                    <p>
                        @if(auth()->id() === $buyer->id)
                            {{ $seller->name }}
                        @else
                            {{ $buyer->name }}
                        @endif
                    </p>
                    <img src="{{ asset($message->user->profile->img_url) }}" alt="" class="user-img">
                </div>
                <p class="other-message-body">{{ $message->body }}</p>
                </div>
            </div>
        @endif
    @endforeach
    </div>


    <!-- 相手のmessage -->
        <form action="{{ route('chat.store', $purchase->id)}}" method="post">
            @csrf
            <div class="flex-btn">
                <input type="text" class="message"name="body" placeholder="取引メッセージを記入してください">
        
        
                <button class="add-btn">画像を追加</button>
                <button class="send-btn">
                    <img src="{{ asset('images/inputbuttun 1.png')}}" alt="" class="input-btn">
                </button>
            </div>
        </form>
        
    </div>
    <!--under-content  -->
    

</div>
<!-- wrapper -->
@endsection


<script>
   document.addEventListener('DOMContentLoaded', () => {
    // 編集ボタンを押したら切り替え
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            document.getElementById('message-' + id).style.display = 'none';
            document.getElementById('form-' + id).style.display = 'block';
            document.querySelector('#form-' + id + ' .edit-input').focus();
        });
    });

    // Enterキーでフォーム送信
    document.querySelectorAll('.edit-input').forEach(input => {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.form.submit();
            }
        });
    });
});
</script>

