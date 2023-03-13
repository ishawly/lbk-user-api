<?php

namespace Database\Seeders;

use App\Models\Record;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::orderByDesc('id')->first();
        Record::factory(10)->create(['user_id' => $user->id]);
    }
}
