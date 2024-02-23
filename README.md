# KickoffReminder
サッカーの試合時間をメールやLINEで通知するアプリです。  
チームの順位や試合結果なども確認することができます。  
<https://kickoffreminder.com>

<img width="500" alt="スクリーンショット 2024-02-21 20 05 04" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/e0174906-35d2-42e6-9e52-475fac072cc3">

## 使用技術
- フロントエンド
    - Vue 3.3.4
    - Vuex 4.1.0
    - Vue Router 4.2.4
    - Tailwind CSS
- バックエンド
    - PHP 8.2.16
    - Laravel 9.52.16
- AWS
    - EC2
    - SES
    - S3
    - RDS (MySQL)
    - Route 53
- その他
    - LINE API
    - football-data.org API
    - GitHub Actions
    - Docker
    - Nginx

## AWS構成図
<img width="500" alt="aws" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/68822772-874e-4faa-a774-f098bc8b247e">

## ER図
<img width="500" alt="er" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/8133f62a-e668-436f-9ce8-92d3c3373698">

## 機能一覧
- cronによる試合情報自動更新
- お気に入りしたチームの試合通知
### 認証機能
- ユーザー登録・退会
- ログイン・ログアウト
- ユーザー情報変更
- パスワード変更・リセット
- LINEログイン
