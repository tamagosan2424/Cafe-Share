# Cafe Share（カフェシェア）

## 概要

**Cafe Share** は、お気に入りのカフェ情報を登録・共有できるWebサービスです。

> カフェの情報を投稿し、メニューやレビューを通じてユーザー同士でカフェ体験をシェアできます。

---

## 作成背景

「このカフェ、雰囲気よかったのに名前忘れた…」「友達におすすめのカフェを教えたい」
そんな経験から、カフェ情報をストックして気軽にシェアできるサービスを作りたいと思い開発しました。

---

## 機能一覧

- **ユーザー登録 / ログイン** （Laravel Breeze / メール認証対応）
- **カフェ投稿** （店名・住所・営業時間・電話番号・説明・メイン画像）
- **カフェ編集 / 削除** （投稿者本人のみ操作可能）
- **サブ画像アップロード** （複数枚の写真を登録可能）
- **Google マップ表示** （カフェ詳細画面に地図を埋め込み）
- **メニュー管理** （メニュー名・価格・説明・画像の登録・削除）
- **レビュー投稿** （星評価 1〜5 ＋ コメント）
- **カフェ一覧** （平均評価・レビュー件数・スター表示付き）

---

## 画面イメージ

| カフェ一覧 | カフェ詳細 |
|---|---|
| カフェカード形式で一覧表示。平均評価のスター・レビュー件数・営業時間を確認できます | カフェ情報・Google マップ・メニュー一覧・レビュー一覧を表示。投稿者はメニューの追加・削除も可能 |

| カフェ登録 | カフェ編集 |
|---|---|
| 店名・住所・営業時間・電話番号・説明・メイン画像を入力して投稿 | 投稿済みのカフェ情報をフォームで更新。サブ画像の追加も可能 |

---

## 使用技術

### バックエンド

| 技術 | バージョン |
|---|---|
| PHP | 8.2 |
| Laravel | 11 |
| Laravel Breeze | 2.4 |
| Inertia.js (Laravel側) | 2.0 |

### フロントエンド

| 技術 | バージョン |
|---|---|
| Vue.js | 3.4 |
| Inertia.js (Vue側) | 2.0 |
| Tailwind CSS | 3.2 |
| Headless UI | 1.7 |
| Vite | 6.0 |

### インフラ / 開発環境

| 技術 | 用途 |
|---|---|
| Docker / Docker Compose | コンテナ構成（Nginx / PHP-FPM / MySQL） |
| MySQL | データベース |
| Google Maps Embed API | カフェ詳細画面の地図表示 |
| Google Places API | カフェ写真の取得 |

---

## ER図 / テーブル構成

```
users
  ├── profiles
  ├── cafes
  │     ├── cafe_images（サブ画像）
  │     ├── menus（メニュー）
  │     ├── reviews（レビュー）
  │     └── cafe_tag（タグ中間テーブル）
  └── tags
```

| テーブル | 主なカラム |
|---|---|
| users | name, email, password |
| cafes | user_id, name, description, address, phone_number, opening_at, closing_at, image |
| cafe_images | cafe_id, image |
| menus | cafe_id, name, description, price, image |
| reviews | cafe_id, user_id, rating, comment |
| tags | name |

---

## セットアップ手順

### 前提条件

- Docker / Docker Compose がインストール済みであること

### 1. リポジトリのクローン

```bash
git clone git@github.com:tamagosan2424/Cafe-Share.git
cd Cafe-Share
```

### 2. 環境変数の設定

```bash
cp src/.env.example src/.env
```

`.env` を以下の内容に編集します。

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel-docker
DB_USERNAME=user
DB_PASSWORD=password

# Google Maps / Places API を使用する場合
GOOGLE_MAPS_API_KEY=your_api_key_here
```

### 3. Dockerコンテナの起動

```bash
docker compose up -d --build
```

### 4. アプリケーションキーの生成

```bash
docker compose exec app php artisan key:generate
```

### 5. マイグレーション & シーダー

```bash
docker compose exec app php artisan migrate --seed
```

### 6. ストレージのリンク作成

```bash
docker compose exec app php artisan storage:link
```

### 7. フロントエンドのビルド

```bash
docker compose exec app npm install
docker compose exec app npm run build
```

### 8. アクセス

[http://localhost:8900](http://localhost:8900) をブラウザで開きます。

---

## 工夫した点

- **認可制御** — `PostPolicy` を用いて、カフェの編集・削除・メニュー操作を投稿者本人のみに制限
- **画像管理** — メイン画像・サブ画像・メニュー画像を `storage/public` に保存し、柔軟に管理
- **Google Maps連携** — カフェの住所をもとにiframe埋め込みで地図を自動表示
- **SPA構成** — Inertia.js により、Laravel + Vue 3 でSPAライクな操作感を実現
- **レスポンシブ対応** — Tailwind CSS でモバイル・PCどちらでも見やすいレイアウト

---

