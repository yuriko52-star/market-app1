@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}" class="">
@endsection

@section('content')
<div class="wrapper">
    <div class="sidebar">
        <p>その他の取引</p>
        @if($otherPurchases->isNotEmpty())
        @foreach($otherPurchases as $p)
        <a href="{{ route('chat.index', $p->id) }}" class="">{{ $p->item->name }}

        </a>
        @endforeach
        @endif
    </div>

    <div class="contents">
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
        
            
            <button class="complete-btn" onclick="openModal()">取引を完了する</button>
            
        @endif
        </div>
    
        <div class="middle-content">
            <img src="{{ asset($item->img_url) }}" alt="" class="">
            <div class="text">
                <p class="item-name">{{ $item->name }}</p>
                <p class="price">{{ number_format($item->price) }}円</p>
            </div>
        </div>

        <div class="under-content">
            <div class="flex">
        @foreach($messages as $message) 
        {{--{{dd($message->image_path)}}--}}
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
                    @if($message->image_path)
                 <div class="chat-image">
                    <img src="{{ asset('storage/' .$message->image_path) }}" alt="添付画像" style="max-width:200px">
                    
                </div>
                
                @endif

               
             {{-- 編集フォーム --}}
                    <form action="{{route('messages.update', $message->id)}}" method="post" class="edit-form" id="form-{{ $message->id }}" style="display:none;">
                    @csrf 
                    @method('PUT')
                        <input type="text"name="body" value="{{$message->body}}"class="edit-input" >
                    </form>
              
                 
                    <div class="btns">
                        <button type="button" class="edit-btn" data-id="{{ $message->id }}">
                        編集
                        </button>
                    
                
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
                 @if($message->image_path)
                 <div class="chat-image">
                    <img src="{{ asset('storage/' .$message->image_path) }}" alt="添付画像" style="max-width:200px">
                    
                </div>
                
                @endif
                </div>
            </div>
        @endif
    @endforeach
    </div>


    <!-- 相手のmessage -->
        <form action="{{ route('chat.store', $purchase->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="flex-btn">
                <input type="text" id="chat-input" class="message"name="body" placeholder="取引メッセージを記入してください">
            
                <input type="file" name="image" id="chat-image" accept="image/*" style="display:none">
                <button type="button"  class="add-btn" onclick="document.getElementById('chat-image').click()">画像を追加</button>
                <button type="submit" class="send-btn">
                    <img src="{{ asset('images/inputbuttun 1.png')}}" alt="" class="input-btn">
                </button>
            </div>
           <div id="image-preview"></div>
        </form>
            <p class="form-error">
                @error('body')
                {{$message}}
                @enderror
            </p>
            <p class="form-error">
                @error('image')
                {{ $message }}
                @enderror
            </p>
        </div>
    </div>
</div>




<!-- モーダル -->
<form action="{{ route('ratings.store', $purchase->id) }}" method="post">
    @csrf
    <div class="modal hidden" id="ratingModal">
    
        <div class="modal-content">
            <div class="top-modal">
                <h2 class="modal-title">取引が完了しました。</h2>
            </div>
            <div class="middle-modal">
                <p class="question">今回の取引相手はどうでしたか？</p>
        <!-- 星評価 -->
                <div class="stars" id="starRating">
                    @for($i = 1; $i <= 5; $i++)
                        <button type ="button" class="star-btn" data-value="{{$i}}">
                            <img src="{{ asset('images/Star 4.png') }}" alt="星{{$i}}">
                        </button>
                    @endfor
                </div>
            </div>
         <!-- 選んだ星の値を送る -->
          <div class="under-modal">
            <input type="hidden" name="rating" id="ratingValue">

            <button type="submit" class="submit-btn">送信する</button>
          </div>
            @if(
                !$purchase->ratings->where('from_user_id', auth()->id())->count() &&
                $purchase->ratings->where('from_user_id', $purchase->buyer->id)->count())

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                    openModal(); // ページロード時に自動でモーダルを表示
                    });
                </script>
            @endif
        </div>
    </div>
</form>

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
<script>
    function openModal() {
    document.getElementById('ratingModal').classList.remove('hidden');
    }
    document.addEventListener('DOMContentLoaded', () => {
        const stars = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('ratingValue');

        stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = star.dataset.value;
            ratingInput.value = value;

            // クリックした星までを黄色に、それ以降は灰色に
            stars.forEach(s => {
                const img = s.querySelector('img');
                if (s.dataset.value <= value) {
                    img.src = '/images/Star 1.png';
                } else {
                    img.src = '/images/Star 4.png';
                }
            });
        });
    });
});

</script>
<!-- 入力情報の保持 -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const chatInput = document.getElementById('chat-input');
        const chatImage = document.getElementById('chat-image');
        const imagePreview = document.getElementById('image-preview');
        const form = chatInput.form;
        const storageKey = `chat-draft-{{ $purchase->id }}`; // 取引ごとにキーを分ける

    // ページ読み込み時に保存された下書きを復元
    chatInput.value = localStorage.getItem(storageKey) || '';

    // 入力が変わるたびに保存
    chatInput.addEventListener('input', () => {
        localStorage.setItem(storageKey, chatInput.value);
    });

// 画像プレビュー
 
   chatImage.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
        const reader = new FileReader();
        reader.onload = function(event) {
            
            imagePreview.innerHTML =`<img src="${event.target.result}" style="max-width:100px">`;
        };
        reader.readAsDataURL(file);
    });

    // 送信時に下書きを削除
        form.addEventListener('submit', () => {
        localStorage.removeItem(storageKey);
        });
    });

    /*input.form.addEventListener('submit', () => {
        localStorage.removeItem(key);
    });
    */
</script>


@endsection

