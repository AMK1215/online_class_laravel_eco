<?php

namespace Database\Seeders;

use App\Models\Admin\Vendor;
use App\Models\Admin\VendorSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all vendors
        $vendors = Vendor::all();

        foreach ($vendors as $vendor) {
            // Create default settings for each vendor
            $settings = $this->getDefaultSettings($vendor);
            
            foreach ($settings as $key => $value) {
                VendorSetting::create([
                    'vendor_id' => $vendor->id,
                    'key' => $key,
                    'value' => $value,
                ]);
            }
        }

        $this->command->info('Vendor settings seeded successfully!');
    }

    /**
     * Get default settings based on vendor type/name
     */
    private function getDefaultSettings(Vendor $vendor): array
    {
        $baseSettings = [
            'auto_approve_orders' => 'true',
            'minimum_order_amount' => '50.00',
            'max_delivery_distance' => '25',
            'delivery_fee' => '5.00',
            'free_delivery_threshold' => '100.00',
            'business_hours' => '09:00-18:00',
            'timezone' => 'America/New_York',
            'currency' => 'USD',
            'tax_rate' => '8.5',
            'notification_email' => $vendor->contact_email ?? 'notifications@example.com',
            'sms_notifications' => 'true',
            'order_lead_time' => '2',
            'max_orders_per_day' => '50',
            'payment_methods' => 'credit_card,cash,paypal',
            'return_policy_days' => '30',
            'warranty_days' => '90',
        ];

        // Add vendor-specific settings based on vendor name
        $specificSettings = $this->getVendorSpecificSettings($vendor);
        
        return array_merge($baseSettings, $specificSettings);
    }

    /**
     * Get vendor-specific settings
     */
    private function getVendorSpecificSettings(Vendor $vendor): array
    {
        $vendorName = strtolower($vendor->name);
        
        if (str_contains($vendorName, 'tech') || str_contains($vendorName, 'software')) {
            return [
                'service_type' => 'technology',
                'project_minimum' => '1000.00',
                'hourly_rate' => '75.00',
                'support_hours' => '24/7',
                'maintenance_plan' => 'true',
                'code_repository' => 'github',
                'deployment_method' => 'automated',
                'backup_frequency' => 'daily',
                'security_audit' => 'monthly',
            ];
        }
        
        if (str_contains($vendorName, 'marketing') || str_contains($vendorName, 'seo')) {
            return [
                'service_type' => 'marketing',
                'campaign_minimum' => '500.00',
                'reporting_frequency' => 'weekly',
                'analytics_tools' => 'google_analytics,facebook_insights',
                'content_calendar' => 'true',
                'social_media_platforms' => 'facebook,instagram,twitter,linkedin',
                'ad_budget_minimum' => '100.00',
                'keyword_research' => 'true',
                'competitor_analysis' => 'true',
            ];
        }
        
        if (str_contains($vendorName, 'design') || str_contains($vendorName, 'creative')) {
            return [
                'service_type' => 'design',
                'design_revisions' => '3',
                'file_formats' => 'psd,ai,pdf,jpg,png,svg',
                'brand_guidelines' => 'true',
                'mockup_included' => 'true',
                'source_files' => 'true',
                'print_ready' => 'true',
                'color_profile' => 'CMYK',
                'resolution' => '300dpi',
            ];
        }
        
        if (str_contains($vendorName, 'e-commerce') || str_contains($vendorName, 'commerce')) {
            return [
                'service_type' => 'ecommerce',
                'platform_specialization' => 'shopify,woocommerce,magento',
                'payment_gateways' => 'stripe,paypal,square',
                'inventory_management' => 'true',
                'order_fulfillment' => 'true',
                'shipping_integration' => 'true',
                'tax_calculation' => 'true',
                'multi_currency' => 'true',
                'mobile_optimization' => 'true',
            ];
        }
        
        if (str_contains($vendorName, 'mobile') || str_contains($vendorName, 'app')) {
            return [
                'service_type' => 'mobile_development',
                'platforms' => 'ios,android',
                'app_store_optimization' => 'true',
                'push_notifications' => 'true',
                'offline_functionality' => 'true',
                'api_integration' => 'true',
                'testing_services' => 'true',
                'maintenance_plan' => 'true',
                'update_frequency' => 'monthly',
            ];
        }
        
        if (str_contains($vendorName, 'hosting') || str_contains($vendorName, 'web')) {
            return [
                'service_type' => 'hosting',
                'uptime_guarantee' => '99.9',
                'ssl_certificate' => 'true',
                'daily_backup' => 'true',
                'cdn_included' => 'true',
                'email_hosting' => 'true',
                'domain_registration' => 'true',
                'technical_support' => '24/7',
                'server_locations' => 'us,europe,asia',
            ];
        }
        
        if (str_contains($vendorName, 'content') || str_contains($vendorName, 'writing')) {
            return [
                'service_type' => 'content',
                'word_count_minimum' => '500',
                'research_included' => 'true',
                'seo_optimization' => 'true',
                'plagiarism_check' => 'true',
                'revision_rounds' => '2',
                'content_calendar' => 'true',
                'keyword_integration' => 'true',
                'content_types' => 'blog,website,social_media,email',
            ];
        }
        
        if (str_contains($vendorName, 'video') || str_contains($vendorName, 'production')) {
            return [
                'service_type' => 'video_production',
                'video_length' => '30-300_seconds',
                'editing_included' => 'true',
                'color_grading' => 'true',
                'motion_graphics' => 'true',
                'voice_over' => 'true',
                'music_licensing' => 'true',
                'delivery_formats' => 'mp4,mov,avi',
                'resolution_options' => '1080p,4k',
            ];
        }
        
        if (str_contains($vendorName, 'social') || str_contains($vendorName, 'media')) {
            return [
                'service_type' => 'social_media',
                'platforms_managed' => 'facebook,instagram,twitter,linkedin,tiktok',
                'posts_per_week' => '5',
                'engagement_monitoring' => 'true',
                'content_creation' => 'true',
                'community_management' => 'true',
                'paid_advertising' => 'true',
                'analytics_reporting' => 'weekly',
                'crisis_management' => 'true',
            ];
        }

        // Default settings for other vendors
        return [
            'service_type' => 'general',
            'custom_requirements' => 'true',
            'consultation_free' => 'true',
            'project_timeline' => '2-4_weeks',
            'quality_guarantee' => 'true',
        ];
    }
}
