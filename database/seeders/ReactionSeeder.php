<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class ReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reactions = [
            [
                'evaluation_id' => 2,
                'subject' => 'おっと、もうこんな時間か',
                'text' => '彼は感謝の一つもせず、用事の準備を始めてしまいました。\r\n問題ありません。これが私達の仕事です、気を落とさないで。さあ、次が来ます。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'evaluation_id' => 3,
                'subject' => '設定と違うような…',
                'text' => '彼は画面越しに疑いの目を向けながら、用事の準備を始めました。\r\n気をつけてください、彼らはワンタップで私達を用済みにできる力を持っています。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'evaluation_id' => 4,
                'subject' => 'びっくりした……まだ時間あるよね',
                'text' => '自分の通知設定が間違っていたのかもしれないと、彼は首を傾げました。\r\nユーザーに与える小さなストレスを軽視しないでください。え、フェイルセーフ？ 「Timer」モジュールはもっと優秀でいいのですよ。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'evaluation_id' => 5,
                'subject' => 'なんだ、驚かせるなよ',
                'text' => '彼は私たちをベッドに放り投げ、去っていきました。悲しい？ こんなことは日常茶飯事です。また次、頑張りましょう。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'evaluation_id' => 6,
                'subject' => 'もうすぐ始まるじゃないか！',
                'text' => '彼は苛立った表情で、慌てて支度を始めました。\r\nどうしましたか？ 他のモジュールとの互換性がうまくいきませんか？ アナタのバージョンは最新ですか？',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'evaluation_id' => 7,
                'subject' => 'おわった',
                'text' => '彼はアナタのおかげで予定をすっぽかし、信頼を失いました。\r\nアナタが負い目を感じる必要はありません。なぜなら、これから信頼を失うのは我々ではなくエンジニアの人たちですから。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'evaluation_id' => 8,
                'subject' => '何がリマインダー？ もういいよ',
                'text' => '配置を変わりますか？ 優秀な「Timer」モジュールは他にもたくさんいます。 もっとも、私達とともに働くこと自体、あなたには向いていないのかもしれません。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        DB::statement('set foreign_key_checks = 0');
        DB::table('reactions')->truncate();
        DB::statement('set foreign_key_checks = 1');

        foreach ($reactions as $reaction) {
            DB::table('reactions')->insert($reaction);
        }
    }
}
