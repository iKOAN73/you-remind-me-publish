<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(InstantUserTableSeeder::class);
        $this->call(EvaluationSeeder::class);
        $this->call(ContentSeeder::class);
        $this->call(ReactionSeeder::class);
    }
}
