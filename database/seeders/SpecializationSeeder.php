<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            [
                'name' => 'Criminal Law',
                'description' => 'Legal practice focused on crimes and criminal offenses',
                'icon' => 'fa-gavel'
            ],
            [
                'name' => 'Civil Law',
                'description' => 'Legal practice dealing with disputes between individuals and organizations',
                'icon' => 'fa-balance-scale'
            ],
            [
                'name' => 'Corporate Law',
                'description' => 'Legal practice focused on business and corporate matters',
                'icon' => 'fa-building'
            ],
            [
                'name' => 'Family Law',
                'description' => 'Legal practice dealing with family-related issues and domestic relations',
                'icon' => 'fa-home'
            ],
            [
                'name' => 'Real Estate Law',
                'description' => 'Legal practice focused on property and real estate transactions',
                'icon' => 'fa-house-user'
            ],
            [
                'name' => 'Intellectual Property Law',
                'description' => 'Legal practice dealing with patents, trademarks, and copyrights',
                'icon' => 'fa-copyright'
            ],
            [
                'name' => 'Employment Law',
                'description' => 'Legal practice focused on workplace rights and employer-employee relations',
                'icon' => 'fa-briefcase'
            ],
            [
                'name' => 'Immigration Law',
                'description' => 'Legal practice dealing with immigration and citizenship matters',
                'icon' => 'fa-passport'
            ],
            [
                'name' => 'Tax Law',
                'description' => 'Legal practice focused on tax-related issues and compliance',
                'icon' => 'fa-receipt'
            ],
            [
                'name' => 'Banking & Finance Law',
                'description' => 'Legal practice dealing with financial institutions and transactions',
                'icon' => 'fa-university'
            ],
            [
                'name' => 'Environmental Law',
                'description' => 'Legal practice focused on environmental protection and regulations',
                'icon' => 'fa-leaf'
            ],
            [
                'name' => 'Health Care Law',
                'description' => 'Legal practice dealing with healthcare regulations and medical issues',
                'icon' => 'fa-heartbeat'
            ],
            [
                'name' => 'Bankruptcy Law',
                'description' => 'Legal practice focused on debt relief and financial restructuring',
                'icon' => 'fa-file-invoice-dollar'
            ],
            [
                'name' => 'Personal Injury Law',
                'description' => 'Legal practice dealing with injuries and accidents',
                'icon' => 'fa-user-injured'
            ],
            [
                'name' => 'Estate Planning',
                'description' => 'Legal practice focused on wills, trusts, and estate management',
                'icon' => 'fa-scroll'
            ],
            [
                'name' => 'Contract Law',
                'description' => 'Legal practice dealing with agreements and contractual obligations',
                'icon' => 'fa-file-contract'
            ],
            [
                'name' => 'International Law',
                'description' => 'Legal practice focused on cross-border and global legal matters',
                'icon' => 'fa-globe'
            ],
            [
                'name' => 'Constitutional Law',
                'description' => 'Legal practice dealing with constitutional rights and government powers',
                'icon' => 'fa-landmark'
            ],
            [
                'name' => 'Cyber Law',
                'description' => 'Legal practice focused on internet, technology, and digital rights',
                'icon' => 'fa-laptop-code'
            ],
            [
                'name' => 'Entertainment Law',
                'description' => 'Legal practice dealing with media, entertainment, and arts',
                'icon' => 'fa-film'
            ],
        ];

        $data = [];
        foreach ($specializations as $specialization) {
            $data[] = [
                'uuid' => Str::uuid(),
                'name' => $specialization['name'],
                'slug' => Str::slug($specialization['name']),
                'description' => $specialization['description'],
                'icon' => $specialization['icon'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('specializations')->insert($data);
    }
}
