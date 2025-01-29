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
            
             <!-- ログイン・登録画面ではナビゲーションを非表示 -->
        <!-- @if (!Request::is('<auth>login') && !Request::is('auth/register')) -->
            <form action="" class="search-form" method="">
                <input type="text" class="search-form__input" placeholder="なにをお探しですか？">
            </form>
            <div class="header-btn-group">
                <!-- <div class="header-link-item"> -->
                <form action="" class="" method="">
                    <button class="btn">ログアウト</button>
                </form>
                <!-- </div> -->
                <!-- <div class="header-link-item"> -->
                <form action="" class="" method="">
                    <button class="btn">マイページ</button>
                </form>
                <!-- </div> -->
                <!-- <div class="header-link-item"> -->
                <form action="" class="" method="">
                    <button class=" btn sell-btn">出品</button>
                </form>
                <!-- </div> -->
            </div>    
            
            <!-- @endif -->
        </div>
        
    </header>

    <main>

        
        @yield('content')

        
    </main>    
   
</div>

</body>
</html>