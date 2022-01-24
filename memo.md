# メモ


- [x] 項目を増やしていくように変更 => OK
- [x] ひとまずjsだけで項目増やしてList出力してみよう => OK

- [x] DB設計 => OK
- [x] タスク内容 [**ユーザーID・タスクID・生成日時・通知期限**] を生成、データベースに保存 => OK

- [x] タスクDB シーディングor 管理CRUD作成  => OK

- [x] CRUDはbladeで作るか、Vue.jsのSPAで作れるか？ => SPA

- [ ] エラーは何？

- [x] VueとBootstrapの共存  => ソース読んでなかった

- [x] Vueの書き方そもそも 単一ファイルコンポーネント => cdnやめて実装 OK

- [x] SPAで作るなら、CUDはポップアップ表示Bootstrapのやつ引用する？
- [x] Vue共存できるように、コンポーネント化 => CRUD対象別に
- [x] Reactions CRUDは、Reminder画面からのみ遷移（SPA）可能。 ゆくゆくは管理者のみ。 → 
- [x] 他、contentsのCRUDでも流用したい。 

- [ ] https://qiita.com/KKDDD/items/afe9da81e4150b8adbc7
- [ ] https://qiita.com/yukibe/items/36ebeca50ecad3ee18f6


## ロジック組む系
- [x] ランダム時間でリクエスト、既存タスクコンテンツからランダムでタスク作成、追加してレスポンス
- [x] 通知後の評価。サーバーにリクエスト、DBの時間と現在時刻を照合、評価（ベタ打ち条件？）、セリフと評価をaxios返送
- [x] 最後のセリフをリアクションから取得


- [ ] 新タスク＝フォーム優先で追加 サーバー側でデータ加工してDB登録 =>adminなので後で

- [ ] 多対多の紐付け タグ的表示 =>

- [x] limitは時刻ではなく時間 default_limit、taskの方にlimit（defaultlimitを参考にストア、後でEditは可能）

- [ ] レスポンシブ
- [ ] Admin/user 棲み分け
  - [ ] User
    - [ ] 最初のモーダル案内=> new user session 保存時に、firstVisitを植え付け、案内モーダルクローズ時に解消
      - [ ] 優秀なタイマーモジュールであるアナタは、このなんの変哲もないリマインダーアプリの一員として呼び出されました。
      - [ ] 「アナタのタイマーIDは  です。 研修期間はありません。 では、一緒に頑張りましょう。ほら、タスクが来ますよ」
      - [ ] タスクには予定時間が表示されます。ちょうどいいタイミングで通知してあげましょう。通知の目安は私が書いておきました。
    - [x] 最初からやり直す
    - [x] Admin隠す
  - [x] Admin判定
- [ ] 得点表示（信頼度）
- [ ] ゲームオーバー


- [x] Laravelにjsで生成したタスクIDを渡し、Laravelからタスク内容を返す ✗
  - [x] → Laravelでランダム生成したタスクIDでタスク生成、Laravelからタスク内容を返す のほうが自然
  - [x] jsは、タイミングだけサーバー側へ通知し、値を待つ。

- [x] 画面起動時はデータベースのタスクをすべて表示する。→Bladeの@foreachでいけそう -> Vue.jsでいけました

- [x] ゆくゆくはタスク内容もデータベースで管理して利用する

- [ ] validation(modal)(db)