<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLEA MARKET</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
   
    <div class="container">
        
    <header class="header">
        <div class="header__inner">
             <div class="header-utilities">
            <a href="" class="header__logo">
                <img src="{{ asset('images/logo (1).svg') }}" > 
            </a>
                <form action="{{route('item.search')}}" class="search-form" method="get">
                    <input type="text" name="keyword" class="search-form__input" placeholder="なにをお探しですか？"  >
                <button type="submit" class="hidden-button"></button>
            </form>
        <nav>
        <ul class="header-nav">
        @auth
           
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn logout-btn">ログアウト</button>
                </form>
            </li>
        @else
           
            <li>
                <a href="{{ route('login') }}" class="header-nav-link">ログイン</a>
            </li>
        @endauth

        <li>
        @if(auth()->check())
        @if(auth()->user()->hasVerifiedEmail())
            <a href="/mypage" class="header-nav-link">マイページ</a>
        @else
            <a href="{{ route('verification.notice') }}" class="header-nav-link">マイページ</a>
        @endif
        @else
        <a href="{{ route('login') }}" class="header-nav-link">マイページ</a>
        @endif
        </li>

        <li>
        @if(auth()->check())
        @if(auth()->user()->hasVerifiedEmail())
            <a href="/sell" class="header-nav-link sell-btn">出品</a>
        @else
            <a href="{{ route('verification.notice') }}" class="header-nav-link sell-btn">出品</a>
        @endif
        @else
        <a href="{{ route('login') }}" class="header-nav-link sell-btn">出品</a>
        @endif
        </li>
         </ul>
        </nav>
        </div> 
        </div>
    </header>

    <main>

        
        @yield('content')
        @yield('js')
        
    </main>    
   
</div>

</body>
</html>