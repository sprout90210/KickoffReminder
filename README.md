# Kickoff Reminder
<https://kickoffreminder.com>

ユーザーがお気に入り登録したサッカーチームの試合時刻を通知するwebアプリです。  
試合結果や順位表なども確認することができます。  

<img width="600" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/232beef1-7345-40d3-bf05-b9fe6b24a450">

## 機能一覧
- 最新データの自動更新(football-data.org API)
- 試合時刻の通知(SES, LINE API)
- 通知のタイミング変更
- 試合やチームの情報表示
- お気に入りチームの登録・解除
#### 認証機能
- ユーザー登録・退会
- ログイン・ログアウト
- LINEログインによる外部認証
- ユーザー情報変更
- パスワード変更・リセット

## 画面イメージ
### チーム,コンペティション詳細画面
順位表、試合結果、予定なども確認できます。  
<img width="700" alt="team" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/408db1c9-9616-4310-9373-517bdf64b2f2">

### お気に入りチーム
お気に入り一覧表示、解除が可能です。  
<img width="700" alt="favorite" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/01092be8-ee8f-4480-babd-dbcb0f031979">

### 試合通知リスト
通知される予定の試合が確認できます。また、通知時刻や通知の受信可否が変更できます。  
<img width="700" alt="reminder" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/370a28ec-66af-4634-ac32-a51110c975a5">

### 認証画面
<img width="700" alt="auth" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/0688dc7a-d0a6-497e-aab8-6f21f438f137">

### レスポンシブ対応
<img width="300" alt="responsive" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/9d0f69e4-de68-4fa0-9c6c-d2cb1d582393">

### 通知メール
<img width="400" alt="email" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/1ff955d1-71bf-4750-83c8-733e5d9f13db">

## 使用技術
- フロントエンド
    - Vue 3.3.4
    - Vuex 4.1.0
    - Vue Router 4.2.4
    - Tailwind CSS
- バックエンド
    - PHP 8.2.17
    - Laravel 9.52.16
- AWS
    - VPC
    - EC2
    - SES
    - S3
    - RDS (MySQL)
    - Route 53
- その他
    - LINE API
    - football-data.org API
    - Docker
    - GitHub Actions
    - Redis
    - nginx
    - Postman
    - phpMyAdmin

## ER図
<img width="500" alt="er" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/7b632529-540f-43b5-8b1f-24bdb740477a">

## AWS構成図
<img width="600" alt="aws" src="https://github.com/sprout90210/KickoffReminder/assets/139374496/68822772-874e-4faa-a774-f098bc8b247e">

