# todoアプリ作成にあたって
備忘録的に作成した手順やミスしたポイントをまとめてあります。

## 使用技術
- PHP (8.2.0)
- Laravel (8.83.27) →laravel9は参考にできるドキュメントが少ないため勉強のために一つ下げてアプリ制作した。
- mysql (8.0.31)

# 作成手順
## アプリ作成
`composer create-project "laravel/laravel=8.*" .`にてファイル作成

## データベースの設定
`mysql`
から
`mysql> create database myapp_todo;`
でデータベース作成

.envを編集

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myapp_todo *ここをデータベース名に変更
DB_USERNAME=root
DB_PASSWORD=
```


