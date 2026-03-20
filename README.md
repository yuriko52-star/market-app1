# market-app1  

## 環境構築  
### クローンとDockerDesktopアプリの立ち上げ  
1. git clone git@github.com:yuriko52-star/market-app1.git  
2. mv market-app1 お好きなリポジトリ名  
3. リポジトリ下でgit remote set-url origin git@github.com:作成したリポジトリ.git　　
4. git remote -v  
5. git add .  
6. git commit -m "コメント"  
7. git push origin main  
8. docker-compose up -d --build  
### Laravel環境構築  
1. docker-compose exec php bash  
2. composer install  
3. cp .env.example .env  
4. .envに環境変数を追加  
    DB_HOST = mysql  
    DB_DATABASE=laravel_db  
    DB_USERNAME=laravel_user  
    DB_PASSWORD=laravel_pass  
5. アプリケーションキーの作成  
    php artisan key:generate  
6. マイグレーションの実行  
    php artisan migrate  
7. シーディングの実行  
    php artisan db:seed   
8. シンボリックリンク  
    php artisan storage:link
##  メール認証  
     .envファイルに追加  
    MAIL_MAILER=smtp  
    MAIL_HOST=mailhog  
    MAIL_PORT=1025  
    MAIL_USERNAME=null  
    MAIL_PASSWORD=null  
    MAIL_ENCRYPTION=null  
    MAIL_FROM_ADDRESS=test@example.com (例)  
    MAIL_FROM_NAME="Market App1"（例）  
##  stripe決済の設定    
    .envに STRIPE＿KEYとSTRIPE＿SECRETを貼り付ける  

## ユーザーのダミーデータ  

    1.  
        名前：織田信長   
        メールアドレス:nobu@gmail.com  
    　　パスワード：nobunobunobu  
        出品した商品： 腕時計、HDD、玉ねぎ３束、革靴、ノートPC  


    2.  
        名前：徳川家康  
        メールアドレス：hurudanuki@gmail.com  
        パスワード：ponponpon  
        出品した商品：マイク、ショルダーバッグ、タンブラー、コーヒーミル、メイクセット  

    3.  
        名前：セネカ  
        メールアドレス:seneka@roma.com  
        パスワード:senekaseneka  
        
## pro入会テストで新たに実行したこと  
1.  php artisan make:migration add_status_to_purchases_table --table=purchases  
    で 既存のpurchasesテーブルにstatusカラムを追加  
2. mypage.blade.phpに 取引中商品のタブを追加  
3. チャット用のmessagesテーブルを作成  
4. 星評価のためのratingsテーブルを作成  
5. Mailable クラスを作成  
 
 
## ご案内  
この度、新たな機能を追加いたしました。チャットにて出品者様と購入者様がじかにやりとりができるようになっております。修正をしたいときは、編集ボタンを押すと入力フォームに切り替わりますのでそのまま入力してエンターキーを押してください。  

セネカ様へのご伝言  
お世話になっております。
アプリ作成者より新規登録完了したとの連絡が入りました。ログイン画面に進んでいただけますが、プロフィール設定が未完のため恐れ入りますが設定をお願いいたします。マイページボタンを押していただくとメール認証に入ります。完了しましたらプロフィール画面に推移しますので入力のほどよろしくお願いいたします。 




## URL
- 開発環境：http://localhost/  

- phpMyAdmin:http://localhost:8080/  

- メール認証(MailHog): http://localhost:8025/  

## ER図  
  
![ER図](erd.png)  

## 使用技術（実行環境）  
 - PHP7.4.9  
 - Laravel8.83.29  
 - MySQL8.0.26  