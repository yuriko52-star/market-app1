<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FLEA MARKET</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" class=""> -->
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
                <input type="text" name="keyword" class="search-form__input" placeholder="なにをお探しですか？">
                <button type="submit" class="hidden-button"></button>
            </form>
            <!-- <div class="header-btn-group"> -->
    <nav>
        <ul class="header-nav">
        @auth
            <!-- 認証済みの場合（ログイン中） -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn logout-btn">ログアウト</button>
                </form>
            </li>
        @else
            <!-- 未認証の場合（ログインしていない） -->
            <li>
                <a href="{{ route('login') }}" class="header-nav-link">ログイン</a>
            </li>
        @endauth
            <li>
                <!-- <form action="" class="" method=""> -->
                    <!-- <button class="btn">マイページ</button> -->
                <!-- </form> -->
                <!-- リンクになるかも -->
                 <a href="/mypage" class="header-nav-link">マイページ</a>
            </li>
            <li>
                <a href="/sell" class="header-nav-link sell-btn">出品</a> 
                <!-- <form action="" class="" method=""> 
                    <button class=" btn sell-btn">出品</button>
                </form>
                -->
            </li>
                
        </ul>  
    </nav>
            <!-- <div class="header-btn-group"> 
                <form action="/logout" class="" method="post">
                    @csrf
                    <button class="btn">ログアウト</button>
                </form>
                
                <form action="" class="" method="">
                    <button class="btn">マイページ</button>
                </form>
                 リンクになるかも -->
                 <!-- <a href="" class="link">マイページ</a> 
                
                <form action="" class="" method="">
                    <button class=" btn sell-btn">出品</button>
                </form>
              -->    
            </div> 
             
            
            
        </div>
        
    </header>

    <main>

        
        @yield('content')

        
    </main>    
   
</div>

</body>
</html>