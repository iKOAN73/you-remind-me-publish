<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $evaluations = [
            'None',
            'Optimal!!!',
            'Pertinent...',
            'Early.',
            'Too Early!',
            'Late! Task Will Start Soon!',
            'Too Late!!! Task Already Started!',
            'I Was Shocked',
        ];

        DB::statement('set foreign_key_checks = 0');
        DB::table('evaluations')->truncate();
        DB::statement('set foreign_key_checks = 1');

        foreach ($evaluations as $evaluation) {
            DB::table('evaluations')->insert([
                'evaluation' => $evaluation,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]);
        }
    }
}
