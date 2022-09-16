# udemy Laravel 講座　第３段
## ダウンロード方法
git clone https://github.com/xxxxx

git close -b ブランチ名 https://github.com/xxxxx

もしくは、zipファイルでダウンロード

## インストール方法
- cd laravel_uReserve
- composer install
- npm install
- npm run dev

.envファイルの中の下記を環境に合わせて変更

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

XAMPP/MAMPPまたは他の開発環境でDBを起動した後に、

php artisan migrate:fresh --seed

と実行すると、テーブルとダミーデータが作成されます。

最後に
php artisan key:generate
と入力してキーを生成後、
php artisan serve
で簡易サーバーを立ち上げて表示を確認してください

## インストール後の実施事項

画像のリンク
php arisan storage:link

プロフィールページで画像アップロード機能を使う場合は、
.envのAPP_URLを下記に変更してください。
APP_URL=http://127.0.0.1:8000

Tailwindcss 3.xの、JustInTime機能により、
使ったHTML内クラスのみ反映されるようになっているので、HTMLを変更したら、
npm run dev
も実行しながら編集するようにしてください。



