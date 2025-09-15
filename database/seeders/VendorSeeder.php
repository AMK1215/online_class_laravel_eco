<?php

namespace Database\Seeders;

use App\Models\Admin\Vendor;
use App\Models\User;
use App\Enums\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin users to assign as vendor owners
        $adminUsers = User::where('type', UserType::Admin->value)->get();
        
        // Create sample vendors
        $vendors = [
            [
                'user_id' => $adminUsers->first()?->id,
                'name' => 'Tech Solutions Pro',
                'description' => 'Leading technology solutions provider specializing in software development and IT consulting services.',
                'status' => true,
                'contact_email' => 'contact@techsolutionspro.com',
                'contact_phone' => '+1-555-0101',
                'address' => '123 Tech Street, Silicon Valley, CA 94025',
                'commission_rate' => 15.00,
            ],
            [
                'user_id' => $adminUsers->first()?->id,
                'name' => 'Digital Marketing Experts',
                'description' => 'Full-service digital marketing agency offering SEO, PPC, social media, and content marketing services.',
                'status' => true,
                'contact_email' => 'hello@digitalmarketingexperts.com',
                'contact_phone' => '+1-555-0102',
                'address' => '456 Marketing Ave, New York, NY 10001',
                'commission_rate' => 12.50,
            ],
            [
                'user_id' => $adminUsers->first()?->id,
                'name' => 'Creative Design Studio',
                'description' => 'Professional graphic design and branding services for businesses of all sizes.',
                'status' => true,
                'contact_email' => 'info@creativedesignstudio.com',
                'contact_phone' => '+1-555-0103',
                'address' => '789 Design Blvd, Los Angeles, CA 90210',
                'commission_rate' => 18.00,
            ],
            [
                'user_id' => $adminUsers->first()?->id,
                'name' => 'E-commerce Solutions',
                'description' => 'Complete e-commerce platform development and online store management services.',
                'status' => true,
                'contact_email' => 'sales@ecommercesolutions.com',
                'contact_phone' => '+1-555-0104',
                'address' => '321 Commerce St, Chicago, IL 60601',
                'commission_rate' => 20.00,
            ],
            [
                'user_id' => $adminUsers->first()?->id,
                'name' => 'Mobile App Developers',
                'description' => 'Expert mobile application development for iOS and Android platforms.',
                'status' => true,
                'contact_email' => 'dev@mobileappdevelopers.com',
                'contact_phone' => '+1-555-0105',
                'address' => '654 App Way, Austin, TX 73301',
                'commission_rate' => 25.00,
            ],
            [
                'user_id' => $adminUsers->first()?->id,
                'name' => 'Web Hosting Services',
                'description' => 'Reliable web hosting and domain registration services with 99.9% uptime guarantee.',
                'status' => true,
                'contact_email' => 'support@webhostingservices.com',
                'contact_phone' => '+1-555-0106',
                'address' => '987 Hosting Dr, Dallas, TX 75201',
                'commission_rate' => 10.00,
            ],
            [
                'user_id' => $adminUsers->first()?->id,
                'name' => 'Content Writing Agency',
                'description' => 'Professional content writing, copywriting, and editorial services for businesses.',
                'status' => true,
                'contact_email' => 'write@contentwritingagency.com',
                'contact_phone' => '+1-555-0107',
                'address' => '147 Content Lane, Seattle, WA 98101',
                'commission_rate' => 14.00,
            ],
            [
                'user_id' => $adminUsers->first()?->id,
                'name' => 'Video Production Studio',
                'description' => 'High-quality video production, editing, and post-production services for marketing and entertainment.',
                'status' => true,
                'contact_email' => 'produce@videoproductionstudio.com',
                'contact_phone' => '+1-555-0108',
                'address' => '258 Video Ave, Miami, FL 33101',
                'commission_rate' => 22.00,
            ],
            [
                'user_id' => $adminUsers->first()?->id,
                'name' => 'SEO Optimization Experts',
                'description' => 'Search engine optimization services to improve your website ranking and visibility.',
                'status' => false, // Inactive vendor
                'contact_email' => 'seo@seooptimizationexperts.com',
                'contact_phone' => '+1-555-0109',
                'address' => '369 SEO Street, Denver, CO 80201',
                'commission_rate' => 16.50,
            ],
            [
                'user_id' => $adminUsers->first()?->id,
                'name' => 'Social Media Management',
                'description' => 'Comprehensive social media management and community engagement services.',
                'status' => true,
                'contact_email' => 'social@socialmediamanagement.com',
                'contact_phone' => '+1-555-0110',
                'address' => '741 Social Blvd, Portland, OR 97201',
                'commission_rate' => 13.00,
            ],
        ];

        foreach ($vendors as $vendorData) {
            Vendor::create($vendorData);
        }

        $this->command->info('Vendors seeded successfully!');
    }
}
