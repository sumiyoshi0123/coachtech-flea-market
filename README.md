アプリケーション名
# coachtechフリマ
 
作成した目的 　
## coachtechブランドのアイテムを出品する

## アプリケーションURL

## 機能一覧
・会員登録

・ログイン

・ログアウト

・商品一覧取得

・商品詳細取得

・商品お気に入り一覧取得

・ユーザー情報取得

・ユーザー購入商品一覧取得

・ユーザ出品商品一覧取得

・プロフィール変更

・商品お気に入り追加

・商品お気に入り削除

・商品コメント追加

・商品コメント削除

・出品

## 使用技術
 ・Laravel Framework 8.83.8
 
 ・@vue/cli 5.0.8

## テーブル設計
 

## ER図


## 環境構築
1.リポジトリのクローン  
git clone git@github.com:sumiyoshi0123/coachtech-flea-market.git  
cd coachtech-flea-market  
code coachtech-flea-market  

2.Docker の設定  
docker-compose up -d --build

3.Laravelのセットアップ  
docker-compose exec php bash  
composer install  
composer create-project --prefer-dist laravel/laravel coachtech-flea-market  
cp .env.example .env  
  .env’ファイルを編集してデータベース情報を設定  
 php artisan migrate  

4.サーバーの起動  
php artisan serve

5.Vue.jsのセットアップ  
npm install  
npm install vue  
npm install vue-loader  

npm run dev  

6.ブラウザで http://localhost/#/item にアクセスする
