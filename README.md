# demo
デモコード
▼ 提出テーマの主要ディレクトリ構造
wp-content/themes/kassy-markup/
├── functions.php             # 各種incファイルの読み込み起点
├── style.css                 # テーマ定義（軽量化し、実体はassetsへ集約）
├── screenshot.png            # スクリーンショット
├── header.php / footer.php   # 共通ヘッダー・フッター
│
├── admin/                    # 【テーマ独自設定画面】
│   ├── theme-options.php     # 設定画面のメインロジック
│   ├── inc/                  # 設定パネル毎のフィールドセット（共通 / SNS / PWA等）
│   ├── css/                  # 管理画面専用スタイル
│   └── js/                   # 管理画面専用スクリプト（Ajaxによる非同期データ入出力等）
│
├── function/                 # 【バックエンド機能の完全モジュール化】
│   ├── kms-option.php        # コモン関数の設定
│   ├── site-option.php       # サイト毎の個別設定
│   └── inc/                  # 機能別に完全分離した関数群
│       ├── enqueue.php       # スクリプト・スタイルシートの最適化読み込み
│       ├── custom-post.php   # カスタム投稿タイプ・カスタムタクソノミー定義
│       ├── json-ld.php       # Schema.org 構造化データの自動生成・出力
│       ├── seo.php / ogp.php # プラグインに頼らないSEO・メタタグ生成内部設計
│       ├── toc.php           # 記事目次の自動生成処理
│       └──  ....    # 必要に応じて追加
│
├── assets/                   # 【フロントエンド：FLOCSS設計】
│   ├── css/
│   │   ├── foundation/       # _variable.styl, _reset.styl, _base.styl
│   │   ├── layout/           # _header.styl, _footer.styl, _main.styl
│   │   ├── object/           # component（汎用パーツ）, project（固有要素）, utility
│   │   └── theme.styl        # プリプロセッサによるコンパイル・集約の起点
│   └── js/
│       └── main.js           # コモンJS（ナビ開閉、スムーズスクロール等のトリガー分離）
│
├── template/                 # 【ルート肥大化防止】メインテンプレート群
│
└── template-parts/           # 【コンポーネント化】再利用性の高いHTMLパーツ群
    ├── head.php / pwa-meta.php
    ├── breadcrumb.php        # パンくず生成コンポーネント
    ├── cta.php               # CTA共通セクション
    ├── loop-(*).php / card-(*).php  # ループ処理とカードデザインのコンポーネント分離
    └── ....    # 必要に応じて追加やコモンからの分離。

