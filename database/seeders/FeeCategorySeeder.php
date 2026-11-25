<?php

namespace Database\Seeders;

use App\Models\FeeCategory;
use Illuminate\Database\Seeder;

class FeeCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Admission Fee', 'description' => 'One-time admission charge', 'default_amount' => 5000],
            ['name' => 'Tuition Fee', 'description' => 'Monthly tuition fee', 'default_amount' => 2000],
            ['name' => 'Exam Fee', 'description' => 'Exam registration fee', 'default_amount' => 500],
            ['name' => 'Sports Fee', 'description' => 'Annual sports fee', 'default_amount' => 300],
            ['name' => 'Registration Fee', 'description' => 'Yearly registration', 'default_amount' => 1000],
            ['name' => 'Library Fee', 'description' => 'Library access fee', 'default_amount' => 200],
            ['name' => 'Lab Fee', 'description' => 'Science lab usage fee', 'default_amount' => 500],
            ['name' => 'Transport Fee', 'description' => 'Monthly bus fee', 'default_amount' => 1500],
            ['name' => 'Hostel Fee', 'description' => 'Monthly hostel charge', 'default_amount' => 3000],
            ['name' => 'Development Fee', 'description' => 'School development charge', 'default_amount' => 2000],
            ['name' => 'Session Charge', 'description' => 'Session/Yearly charge', 'default_amount' => 1500],
            ['name' => 'Late Fine', 'description' => 'Late payment penalty', 'default_amount' => 100],
        ];

        foreach ($categories as $cat) {
            FeeCategory::updateOrCreate(
                ['name' => $cat['name']],
                $cat
            );
        }

        $this->command->info('✅ ' . count($categories) . ' fee categories created!');
    }
}