<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VaccineCenter;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        VaccineCenter::factory(20)->create();

        $this->call(UserSeeder::class);
    }
}
