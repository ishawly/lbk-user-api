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
        // user
        \App\Models\User::factory()->create(['id' => 1, 'name' => 'system1']);
        \App\Models\User::factory()->create(['id' => 1000, 'name' => 'system1000']);
        \App\Models\User::factory(20)->create();

        // category
        (new CategorySeeder())->run();

        // record
        (new RecordSeeder())->run();
    }
}
