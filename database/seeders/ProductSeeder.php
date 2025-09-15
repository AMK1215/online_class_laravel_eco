<?php

namespace Database\Seeders;

use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Admin\ProductStatus;
use App\Models\Admin\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data for relationships
        $vendors = Vendor::all();
        $categories = ProductCategory::all();
        $statuses = ProductStatus::all();

        if ($vendors->isEmpty() || $categories->isEmpty() || $statuses->isEmpty()) {
            $this->command->warn('Required data not found. Please run VendorSeeder, ProductCategorySeeder, and ProductStatusSeeder first.');
            return;
        }

        // Sample product data
        $products = [
            // Electronics
            [
                'name' => 'iPhone 15 Pro Max',
                'description' => 'Latest iPhone with A17 Pro chip, 48MP camera, and titanium design. Features advanced photography capabilities and all-day battery life.',
                'price' => 1199.99,
                'quantity' => 50,
                'category_name' => 'Smartphones',
                'status_name' => 'Active'
            ],
            [
                'name' => 'MacBook Air M2',
                'description' => 'Ultra-thin laptop with M2 chip, 13.6-inch Liquid Retina display, and up to 18 hours of battery life. Perfect for productivity and creativity.',
                'price' => 1199.00,
                'quantity' => 30,
                'category_name' => 'Laptops',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Premium noise-canceling headphones with exceptional sound quality, 30-hour battery life, and advanced noise cancellation technology.',
                'price' => 399.99,
                'quantity' => 75,
                'category_name' => 'Headphones',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Canon EOS R6 Mark II',
                'description' => 'Full-frame mirrorless camera with 24.2MP sensor, 4K video recording, and advanced autofocus system for professional photography.',
                'price' => 2499.00,
                'quantity' => 15,
                'category_name' => 'Cameras',
                'status_name' => 'Active'
            ],

            // Fashion & Clothing
            [
                'name' => 'Premium Cotton T-Shirt',
                'description' => 'High-quality 100% organic cotton t-shirt with modern fit, available in multiple colors. Comfortable and durable for everyday wear.',
                'price' => 29.99,
                'quantity' => 200,
                'category_name' => 'Men\'s Clothing',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Designer Handbag',
                'description' => 'Elegant leather handbag with multiple compartments, gold hardware, and adjustable shoulder strap. Perfect for professional and casual use.',
                'price' => 199.99,
                'quantity' => 25,
                'category_name' => 'Bags & Handbags',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Running Shoes',
                'description' => 'Lightweight running shoes with advanced cushioning technology, breathable mesh upper, and durable rubber outsole for optimal performance.',
                'price' => 129.99,
                'quantity' => 80,
                'category_name' => 'Shoes',
                'status_name' => 'Active'
            ],

            // Home & Garden
            [
                'name' => 'Ergonomic Office Chair',
                'description' => 'Premium office chair with adjustable lumbar support, breathable mesh back, and ergonomic design for maximum comfort during long work hours.',
                'price' => 299.99,
                'quantity' => 40,
                'category_name' => 'Furniture',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Smart Coffee Maker',
                'description' => 'Programmable coffee maker with built-in grinder, multiple brewing options, and smartphone app control for the perfect cup every time.',
                'price' => 199.99,
                'quantity' => 60,
                'category_name' => 'Kitchen Appliances',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Garden Tool Set',
                'description' => 'Complete garden maintenance kit including pruners, trowel, rake, and gloves. Made from high-quality steel with ergonomic handles.',
                'price' => 89.99,
                'quantity' => 100,
                'category_name' => 'Garden Tools',
                'status_name' => 'Active'
            ],

            // Sports & Outdoors
            [
                'name' => 'Yoga Mat Premium',
                'description' => 'Non-slip yoga mat with extra cushioning, perfect thickness for comfort, and eco-friendly materials. Includes carrying strap.',
                'price' => 49.99,
                'quantity' => 150,
                'category_name' => 'Fitness Equipment',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Camping Tent 4-Person',
                'description' => 'Spacious 4-person tent with weather-resistant fabric, easy setup design, and multiple ventilation options for comfortable camping.',
                'price' => 179.99,
                'quantity' => 35,
                'category_name' => 'Outdoor Gear',
                'status_name' => 'Active'
            ],

            // Books & Media
            [
                'name' => 'The Art of Programming',
                'description' => 'Comprehensive guide to modern programming practices, covering multiple languages and best practices for software development.',
                'price' => 39.99,
                'quantity' => 120,
                'category_name' => 'Non-Fiction Books',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Classic Movie Collection',
                'description' => 'Box set of 10 classic films in high-definition Blu-ray format, including bonus features and director commentaries.',
                'price' => 79.99,
                'quantity' => 45,
                'category_name' => 'Movies & DVDs',
                'status_name' => 'Active'
            ],

            // Health & Beauty
            [
                'name' => 'Anti-Aging Serum',
                'description' => 'Advanced anti-aging formula with retinol, hyaluronic acid, and vitamin C. Clinically proven to reduce fine lines and wrinkles.',
                'price' => 89.99,
                'quantity' => 90,
                'category_name' => 'Skincare',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Professional Hair Dryer',
                'description' => 'Ionic hair dryer with multiple heat settings, cool shot button, and concentrator nozzle for salon-quality results at home.',
                'price' => 159.99,
                'quantity' => 55,
                'category_name' => 'Hair Care',
                'status_name' => 'Active'
            ],

            // Automotive
            [
                'name' => 'Car Phone Mount',
                'description' => 'Universal smartphone holder for car dashboard with adjustable angle, secure grip, and easy one-touch installation.',
                'price' => 24.99,
                'quantity' => 200,
                'category_name' => 'Car Electronics',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Premium Car Wax',
                'description' => 'Professional-grade car wax with long-lasting protection, deep shine, and water-repellent properties for showroom finish.',
                'price' => 34.99,
                'quantity' => 180,
                'category_name' => 'Car Care',
                'status_name' => 'Active'
            ],

            // Additional products for variety
            [
                'name' => 'Wireless Bluetooth Speaker',
                'description' => 'Portable speaker with 360-degree sound, waterproof design, and 20-hour battery life. Perfect for outdoor activities and parties.',
                'price' => 79.99,
                'quantity' => 95,
                'category_name' => 'Electronics',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Organic Cotton Bedding Set',
                'description' => 'Luxury bedding set made from 100% organic cotton with 400 thread count. Includes fitted sheet, flat sheet, and pillowcases.',
                'price' => 149.99,
                'quantity' => 70,
                'category_name' => 'Home Decor',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Professional Makeup Brush Set',
                'description' => 'Complete makeup brush collection with synthetic bristles, ergonomic handles, and carrying case. Perfect for beginners and professionals.',
                'price' => 69.99,
                'quantity' => 110,
                'category_name' => 'Makeup',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Smart Fitness Watch',
                'description' => 'Advanced fitness tracker with heart rate monitoring, GPS tracking, and smartphone notifications. Water-resistant and long battery life.',
                'price' => 199.99,
                'quantity' => 65,
                'category_name' => 'Electronics',
                'status_name' => 'Active'
            ],
            [
                'name' => 'Gourmet Coffee Beans',
                'description' => 'Premium single-origin coffee beans, medium roast with notes of chocolate and caramel. Freshly roasted and packaged.',
                'price' => 19.99,
                'quantity' => 300,
                'category_name' => 'Food & Beverages',
                'status_name' => 'Active'
            ]
        ];

        // Create products
        foreach ($products as $productData) {
            // Find category by name
            $category = $categories->where('name', $productData['category_name'])->first();
            if (!$category) {
                $category = $categories->first(); // Fallback to first category
            }

            // Find status by name
            $status = $statuses->where('name', $productData['status_name'])->first();
            if (!$status) {
                $status = $statuses->first(); // Fallback to first status
            }

            // Random vendor
            $vendor = $vendors->random();

            Product::create([
                'vendor_id' => $vendor->id,
                'product_category_id' => $category->id,
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'quantity' => $productData['quantity'],
                'product_status_id' => $status->id,
            ]);
        }

        $this->command->info('Products seeded successfully!');
    }
}
