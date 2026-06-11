<?php

namespace Database\Seeders;

use App\Models\CaseHearing;
use App\Models\Client;
use App\Models\Lawyer;
use App\Models\LegalCase;
use App\Models\Schedule;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PracticeManagementSeeder extends Seeder
{
    public function run(): void
    {
        $lawyersData = [
            [
                'name' => 'Barrister Ahmed Raza Khan',
                'email' => 'ahmed.raza@lawconnect.pk',
                'firm_name' => 'Raza & Associates',
                'city' => 'Karachi',
                'years' => 15,
            ],
            [
                'name' => 'Advocate Sana Malik',
                'email' => 'sana.malik@lawconnect.pk',
                'firm_name' => 'Malik Law Chambers',
                'city' => 'Karachi',
                'years' => 9,
            ],
            [
                'name' => 'Advocate Imran Siddiqui',
                'email' => 'imran.siddiqui@lawconnect.pk',
                'firm_name' => 'Siddiqui Legal Consultants',
                'city' => 'Hyderabad',
                'years' => 12,
            ],
        ];

        $teamMembersData = [
            ['Ali Hassan', 'Associate'],
            ['Zainab Qureshi', 'Paralegal'],
            ['Hamza Sheikh', 'Junior Counsel'],
            ['Mariam Aslam', 'Associate'],
            ['Bilal Ansari', 'Legal Researcher'],
            ['Hira Farooq', 'Paralegal'],
        ];

        $clientsData = [
            ['Muhammad Bilal Hussain', 'bilal.hussain@example.pk', 'Karachi'],
            ['Ayesha Tariq', 'ayesha.tariq@example.pk', 'Karachi'],
            ['Usman Ghani', 'usman.ghani@example.pk', 'Karachi'],
            ['Fatima Noor', 'fatima.noor@example.pk', 'Hyderabad'],
            ['Salman Yousuf', 'salman.yousuf@example.pk', 'Karachi'],
            ['Rabia Shahid', 'rabia.shahid@example.pk', 'Karachi'],
            ['Kamran Abbasi', 'kamran.abbasi@example.pk', 'Sukkur'],
            ['Nida Iqbal', 'nida.iqbal@example.pk', 'Karachi'],
            ['Tariq Mehmood', 'tariq.mehmood@example.pk', 'Karachi'],
        ];

        $courts = [
            'Sindh High Court',
            'City Courts Karachi',
            'Family Court Karachi (East)',
            'Banking Court No. 1 Karachi',
            'Sessions Court Karachi (South)',
        ];

        $caseTitles = [
            ['Property dispute over commercial plot in Gulshan-e-Iqbal', 'civil'],
            ['Recovery suit against defaulting vendor', 'civil'],
            ['Khula and child custody proceedings', 'family'],
            ['Bail application in FIR No. 245/2026', 'criminal'],
            ['Shareholder dispute — private limited company', 'corporate'],
            ['Appeal against income tax assessment order', 'tax'],
            ['Tenancy eviction petition — Clifton property', 'civil'],
            ['Inheritance distribution suit', 'family'],
            ['Cheque dishonour case u/s 489-F', 'criminal'],
        ];

        $tmIndex = 0;
        $clientIndex = 0;
        $caseIndex = 0;

        foreach ($lawyersData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'lawyer',
                'is_active' => true,
            ]);
            $user->assignRole('lawyer');

            $lawyer = Lawyer::create([
                'user_id' => $user->id,
                'uuid' => (string) Str::uuid(),
                'bio' => 'Experienced legal practitioner based in ' . $data['city'] . ', specializing in civil and corporate litigation across Sindh courts.',
                'years_of_experience' => $data['years'],
                'firm_name' => $data['firm_name'],
                'city' => $data['city'],
                'state' => 'Sindh',
                'country' => 'Pakistan',
                'is_verified' => true,
            ]);

            // 2 team members per lawyer
            for ($i = 0; $i < 2; $i++) {
                [$tmName, $designation] = $teamMembersData[$tmIndex % count($teamMembersData)];
                $tmIndex++;
                TeamMember::create([
                    'uuid' => (string) Str::uuid(),
                    'lawyer_id' => $lawyer->id,
                    'name' => $tmName,
                    'designation' => $designation,
                    'email' => Str::slug($tmName, '.') . '@' . Str::slug($data['firm_name']) . '.pk',
                    'phone' => '03' . rand(0, 4) . rand(10000000, 99999999),
                    'bio' => $designation . ' at ' . $data['firm_name'] . ' assisting in litigation and client matters.',
                    'qualifications' => 'LL.B, Karachi University',
                    'years_of_experience' => rand(2, 8),
                    'is_active' => true,
                    'order' => $i,
                ]);
            }

            // 3 clients per lawyer, each with a user account
            for ($i = 0; $i < 3; $i++) {
                [$cName, $cEmail, $cCity] = $clientsData[$clientIndex % count($clientsData)];
                $clientIndex++;

                $clientUser = User::create([
                    'name' => $cName,
                    'email' => $cEmail,
                    'password' => Hash::make('password'),
                    'role' => 'client',
                    'is_active' => true,
                ]);
                $clientUser->assignRole('client');

                $client = Client::create([
                    'uuid' => (string) Str::uuid(),
                    'user_id' => $clientUser->id,
                    'lawyer_id' => $lawyer->id,
                    'phone' => '03' . rand(0, 4) . rand(10000000, 99999999),
                    'cnic' => '42101-' . rand(1000000, 9999999) . '-' . rand(1, 9),
                    'address' => 'House No. ' . rand(1, 400) . ', Block ' . rand(1, 18) . ', ' . $cCity,
                    'city' => $cCity,
                    'is_active' => true,
                ]);

                // 1 case per client → 3 cases per lawyer
                [$title, $type] = $caseTitles[$caseIndex % count($caseTitles)];
                $caseIndex++;
                $court = $courts[array_rand($courts)];

                $case = LegalCase::create([
                    'uuid' => (string) Str::uuid(),
                    'lawyer_id' => $lawyer->id,
                    'client_id' => $client->id,
                    'team_member_id' => $lawyer->teamMembers()->inRandomOrder()->value('id'),
                    'case_number' => strtoupper(substr($type, 0, 3)) . '-' . rand(100, 999) . '/2026',
                    'title' => $title,
                    'type' => $type,
                    'court_name' => $court,
                    'judge_name' => 'Hon. Justice ' . ['Khalid Mahmood', 'Shazia Rehman', 'Anwar Baloch'][array_rand([0, 1, 2])],
                    'description' => 'Seeded case for development/testing: ' . $title . '.',
                    'status' => ['pending', 'active', 'active'][array_rand([0, 1, 2])],
                    'filed_date' => now()->subDays(rand(30, 180))->toDateString(),
                    'is_visible_to_client' => true,
                ]);

                // 2 hearings per case: one completed, one upcoming
                $past = CaseHearing::create([
                    'case_id' => $case->id,
                    'hearing_date' => now()->subDays(rand(7, 30))->toDateString(),
                    'hearing_time' => '10:30',
                    'court_name' => $court,
                    'room' => 'Court Room ' . rand(1, 12),
                    'purpose' => 'Framing of issues',
                    'outcome' => 'Issues framed; matter adjourned for evidence.',
                    'status' => 'completed',
                ]);

                $upcomingDate = now()->addDays(rand(3, 21));
                $upcoming = CaseHearing::create([
                    'case_id' => $case->id,
                    'hearing_date' => $upcomingDate->toDateString(),
                    'hearing_time' => '11:00',
                    'court_name' => $court,
                    'room' => 'Court Room ' . rand(1, 12),
                    'purpose' => 'Recording of evidence',
                    'status' => 'scheduled',
                ]);

                $case->update(['next_hearing_date' => $upcomingDate->toDateString()]);

                // Mirror upcoming hearing on the lawyer's schedule
                Schedule::create([
                    'lawyer_id' => $lawyer->id,
                    'title' => 'Hearing: ' . $case->title,
                    'type' => 'hearing',
                    'start_datetime' => $upcomingDate->copy()->setTime(11, 0),
                    'end_datetime' => $upcomingDate->copy()->setTime(12, 0),
                    'location' => $court,
                    'case_id' => $case->id,
                    'is_public' => false,
                ]);
            }

            // A public consultation slot for the public-availability feature
            Schedule::create([
                'lawyer_id' => $lawyer->id,
                'title' => 'Available for consultation',
                'type' => 'consultation',
                'start_datetime' => now()->addDays(rand(1, 5))->setTime(16, 0),
                'end_datetime' => now()->addDays(rand(1, 5))->setTime(18, 0),
                'location' => $data['firm_name'],
                'is_public' => true,
            ]);
        }

        $this->command->info('Practice management demo data seeded (lawyers, teams, clients, cases, hearings, schedules).');
        $this->command->info('Lawyer logins: ahmed.raza@lawconnect.pk / sana.malik@lawconnect.pk / imran.siddiqui@lawconnect.pk — password: password');
        $this->command->info('Client logins: e.g. bilal.hussain@example.pk — password: password');
    }
}
