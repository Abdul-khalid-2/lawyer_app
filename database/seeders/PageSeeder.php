<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'about-us',
                'title' => 'About Us',
                'content' => '<p>LegalConsaltent connects clients with the right legal professionals across Pakistan. Our mission is to make legal representation accessible to everyone.</p>',
                'meta_description' => 'About LegalConsaltent — connecting clients with trusted lawyers across Pakistan.',
            ],
            [
                'slug' => 'terms-of-service',
                'title' => 'Terms of Service',
                'content' => '<p>By using this platform you agree to our terms of service. Content provided by lawyers does not constitute legal advice until a formal engagement is in place.</p>',
                'meta_description' => 'Terms of service for using the LegalConsaltent platform.',
            ],
            [
                'slug' => 'privacy-policy',
                'title' => 'Privacy Policy',
                'content' => '<p>We respect your privacy. Personal information is only used to operate the platform and is never sold to third parties.</p>',
                'meta_description' => 'How LegalConsaltent collects, uses and protects your data.',
            ],
            [
                'slug' => 'faq',
                'title' => 'FAQ',
                'content' => '<h5>How do I find a lawyer?</h5><p>Use the Find Lawyers page to browse profiles by specialization and city.</p><h5>Is it free?</h5><p>Browsing lawyer profiles, articles and videos is completely free.</p>',
                'meta_description' => 'Frequently asked questions about LegalConsaltent.',
            ],
        ];

        foreach ($pages as $data) {
            Page::firstOrCreate(
                ['slug' => $data['slug']],
                $data + ['is_published' => true]
            );
        }

        $this->command->info('Default CMS pages seeded (about-us, terms-of-service, privacy-policy, faq).');
    }
}
