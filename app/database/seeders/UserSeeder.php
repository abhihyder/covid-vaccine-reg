<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VaccineCenter;
use App\Models\VaccineRegistration;
use App\Services\VaccineCenterService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(VaccineCenterService $vaccineCenterService): void
    {
        $centers = VaccineCenter::pluck('id')->toArray();

        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'secret',
            'nid' => '1234567890',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => 'secret',
            'nid' => '1234567891',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user3 = User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice.johnson@example.com',
            'password' => 'secret',
            'nid' => '1234567892',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        User::create([
            'name' => 'Jonh Cena',
            'email' => 'jonh.cena@example.com',
            'password' => 'secret',
            'nid' => '1234567893',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        VaccineRegistration::create(
            [
                'user_id' => $user1->id,
                'vaccine_center_id' => $centers[array_rand($centers)],
                'scheduled_date' => $vaccineCenterService->getNextWeekday(Carbon::now()->addDays(2)),
                'is_vaccinated' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]
        );

        VaccineRegistration::create([
            'user_id' => $user2->id,
            'vaccine_center_id' => $centers[array_rand($centers)],
            'scheduled_date' => $vaccineCenterService->getNextWeekday(Carbon::now()->subDays(5)),
            'is_vaccinated' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        VaccineRegistration::create([
            'user_id' => $user3->id,
            'vaccine_center_id' => $centers[array_rand($centers)],
            'scheduled_date' => $vaccineCenterService->getNextWeekday(Carbon::now()->subDays(3)),
            'is_vaccinated' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
