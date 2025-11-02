<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            ['name' => 'Criminal Law'],
            ['name' => 'Civil Law'],
            ['name' => 'Corporate Law'],
            ['name' => 'Family Law'],
            ['name' => 'Real Estate Law'],
            ['name' => 'Intellectual Property Law'],
            ['name' => 'Employment Law'],
            ['name' => 'Immigration Law'],
            ['name' => 'Tax Law'],
            ['name' => 'Banking & Finance Law'],
            ['name' => 'Environmental Law'],
            ['name' => 'Health Care Law'],
            ['name' => 'Bankruptcy Law'],
            ['name' => 'Personal Injury Law'],
            ['name' => 'Estate Planning'],
            ['name' => 'Contract Law'],
            ['name' => 'International Law'],
            ['name' => 'Constitutional Law'],
            ['name' => 'Cyber Law'],
            ['name' => 'Entertainment Law'],
        ];

        DB::table('specializations')->insert($specializations);
    }
}
