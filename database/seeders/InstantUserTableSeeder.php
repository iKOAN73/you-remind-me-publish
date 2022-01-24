<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstantUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('instant_users')->insert([
            'name' => 'defaultUser',
            'instant_id' => 'qwertyuiiop',
        ]);
    }
}
