<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contents = [
            [
                'limit_span' => '00:03:00',
                'time_notice' => '00:01:00',
                'subject' => '買い物 鍋の具材',
                'memo' => '@ヤオコー 散歩ついでに',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'limit_span' => '00:05:00',
                'time_notice' => '00:02:00',
                'subject' => '家族会議',
                'memo' => '連休の旅行について',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'limit_span' => '00:10:00',
                'time_notice' => '00:05:00',
                'subject' => '通勤',
                'memo' => 'ウイルスを避けながら行く',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'limit_span' => '00:20:00',
                'time_notice' => '00:10:00',
                'subject' => '○○さん 取材',
                'memo' => 'Zoomミーティング',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'limit_span' => '09:00:00',
                'time_notice' => '00:05:00',
                'subject' => '娘を起こす',
                'memo' => '起きても起きなくても文句は言われる。文句は言われるが、起こさなければならない。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'limit_span' => '00:07:00',
                'time_notice' => '00:02:00',
                'subject' => '犬の散歩',
                'memo' => '最近、ジョンは太り気味だ。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'limit_span' => '00:07:00',
                'time_notice' => '00:02:00',
                'subject' => 'ゴミ出し',
                'memo' => '次燃えるゴミの日を逃したらおしまいだ。',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ];

        DB::statement('set foreign_key_checks = 0');
        DB::table('task_contents')->truncate();
        DB::statement('set foreign_key_checks = 1');

        foreach ($contents as $content) {
            DB::table('task_contents')->insert($content);
        }
    }
}
