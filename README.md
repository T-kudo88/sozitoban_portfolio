# 🧹 掃除当番アプリ

Vue 3 × Laravel で構築した、掃除当番の管理アプリです。  
担当者の登録・編集・自動シャッフル機能、タイマー・履歴管理、Slack通知まで対応しています！

---

## ✨ 主な機能

- ✅ ユーザー登録／編集／削除
- 🔄 タスクのランダム割り当て（シャッフル）
- ⏱ 作業用10分タイマー
- 🗓 履歴画面（開始・終了時間を記録）
- 🔔 Slackへの通知機能（任意）

---

## 🛠 使用技術

| 種別 | 技術 |
|------|------|
| フロント | Vue 3 + Vite + TypeScript + Tailwind CSS |
| バックエンド | Laravel 10 |
| ルーティング | Inertia.js |
| DB | MySQL / SQLite（環境により変更可） |
| 通知連携 | Slack Webhook |

---

## 🚀 セットアップ手順

```bash
# クローン
git clone https://github.com/T-kudo88/sozitoban_portfolio.git
cd sozitoban_portfolio

# 依存関係インストール
composer install
npm install

# .env設定
cp .env.example .env
php artisan key:generate

# マイグレーション実行
php artisan migrate

# 開発サーバー起動
php artisan serve
npm run dev

## 💻 画面イメージ

### ホーム画面
![ホーム画面](./public/screenshots/home.png)

### 登録画面
![登録画面](./public/screenshots/register.png)

### 編集画面
![編集画面](./public/screenshots/edit.png)

### 履歴画面
![履歴画面](./public/screenshots/history.png)
