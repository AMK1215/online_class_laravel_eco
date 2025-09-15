# Vendor Seeders Documentation

This document describes the vendor-related seeders that have been created for the user management system.

## Created Seeders

### 1. VendorSeeder (`database/seeders/VendorSeeder.php`)

Creates sample vendor records with realistic business data.

**Features:**
- Creates 10 sample vendors with different business types
- Includes one inactive vendor for testing
- Assigns vendors to admin users
- Sets realistic commission rates (10% - 25%)
- Includes contact information and addresses

**Sample Vendors Created:**
- Tech Solutions Pro (Technology) -> 
- Digital Marketing Experts (Marketing) -> 
- Creative Design Studio (Design)
- E-commerce Solutions (E-commerce)
- Mobile App Developers (Mobile Development)
- Web Hosting Services (Hosting)
- Content Writing Agency (Content)
- Video Production Studio (Video Production)
- SEO Optimization Experts (SEO - Inactive)
- Social Media Management (Social Media)

### 2. VendorSettingSeeder (`database/seeders/VendorSettingSeeder.php`)

Creates comprehensive settings for each vendor based on their business type.

**Features:**
- Creates base settings for all vendors (business hours, delivery fees, etc.)
- Adds vendor-specific settings based on business type
- Intelligent categorization based on vendor name
- Includes realistic business configurations

**Base Settings (All Vendors):**
- Auto approve orders -> manually 
- Minimum order amounts
- Delivery settings
- Business hours and timezone
- Payment methods ->KPay - Wave
- Return policies

**Vendor-Specific Settings:**
- **Technology Vendors:** Project minimums, hourly rates, support hours
- **Marketing Vendors:** Campaign minimums, analytics tools, social platforms
- **Design Vendors:** File formats, revisions, print settings
- **E-commerce Vendors:** Platform specializations, payment gateways
- **Mobile Development:** Platform support, app store optimization
- **Hosting Services:** Uptime guarantees, SSL certificates, backup settings
- **Content Writing:** Word counts, SEO optimization, content types
- **Video Production:** Video lengths, editing services, delivery formats
- **Social Media:** Platform management, posting schedules, analytics

### 3. VendorReviewSeeder (`database/seeders/VendorReviewSeeder.php`)

Creates sample reviews for vendors from players.

**Features:**
- Creates 3-8 reviews per vendor
- Uses realistic review content and ratings (3-5 stars)
- Assigns reviews to random player users
- Sets realistic creation dates (within last 90 days)

### 4. VendorPaymentSeeder (`database/seeders/VendorPaymentSeeder.php`)

Creates sample payment records for vendors.

**Features:**
- Creates 5-15 payments per vendor
- Random amounts between $100-$5000
- Various payment methods (credit card, bank transfer, PayPal, etc.)
- Realistic payment dates (within last year)

## Database Seeder Integration

All seeders have been integrated into the main `DatabaseSeeder` in the correct order:

```php
$this->call([
    RolesTableSeeder::class,
    PermissionsTableSeeder::class,
    PermissionRoleTableSeeder::class,
    UserTableSeeder::class,
    VendorSeeder::class,           // Creates vendors
    VendorSettingSeeder::class,    // Creates vendor settings
    VendorReviewSeeder::class,     // Creates vendor reviews
    VendorPaymentSeeder::class,    // Creates vendor payments
]);
```

## Usage

### Run All Seeders
```bash
php artisan db:seed
```

### Run Individual Seeders
```bash
php artisan db:seed --class=VendorSeeder
php artisan db:seed --class=VendorSettingSeeder
php artisan db:seed --class=VendorReviewSeeder
php artisan db:seed --class=VendorPaymentSeeder
```

### Fresh Database with Seeders
```bash
php artisan migrate:fresh --seed
```

## Data Structure

### Vendors Table
- `id` - Primary key
- `user_id` - Foreign key to users table (admin users)
- `name` - Vendor business name
- `description` - Business description
- `status` - Active/Inactive status
- `contact_email` - Business email
- `contact_phone` - Business phone
- `address` - Business address
- `commission_rate` - Commission percentage
- `created_at`, `updated_at`, `deleted_at` - Timestamps

### Vendor Settings Table
- `id` - Primary key
- `vendor_id` - Foreign key to vendors table
- `key` - Setting name
- `value` - Setting value
- `created_at`, `updated_at` - Timestamps

### Vendor Reviews Table
- `id` - Primary key
- `vendor_id` - Foreign key to vendors table
- `user_id` - Foreign key to users table (player users)
- `rating` - Review rating (1-5)
- `comment` - Review text
- `created_at`, `updated_at` - Timestamps

### Vendor Payments Table
- `id` - Primary key
- `vendor_id` - Foreign key to vendors table
- `amount` - Payment amount
- `payment_date` - Date of payment
- `payment_method` - Method of payment
- `created_at`, `updated_at` - Timestamps

## Notes

- All seeders include proper error handling and informative console messages
- The seeders maintain referential integrity by checking for required related data
- Vendor-specific settings are intelligently assigned based on vendor name keywords
- Review and payment data is randomized to create realistic test scenarios
- All timestamps are set to realistic past dates for better testing
