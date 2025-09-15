<?php

namespace Database\Seeders;

use App\Models\Admin\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Main categories (parent categories)
        $mainCategories = [
            'Electronics',
            'Fashion & Clothing',
            'Home & Garden',
            'Sports & Outdoors',
            'Books & Media',
            'Health & Beauty',
            'Automotive',
            'Toys & Games',
            'Food & Beverages',
            'Office Supplies',
            'Jewelry & Accessories',
            'Art & Crafts',
            'Pet Supplies',
            'Travel & Luggage',
            'Musical Instruments'
        ];

        // Create main categories
        $createdMainCategories = [];
        foreach ($mainCategories as $categoryName) {
            $category = ProductCategory::create([
                'name' => $categoryName,
                'parent_id' => null
            ]);
            $createdMainCategories[$categoryName] = $category;
        }

        // Subcategories for each main category
        $subcategories = [
            'Electronics' => [
                'Smartphones',
                'Laptops',
                'Tablets',
                'Headphones',
                'Cameras'
            ],
            'Fashion & Clothing' => [
                'Men\'s Clothing',
                'Women\'s Clothing',
                'Shoes',
                'Bags & Handbags',
                'Watches'
            ],
            'Home & Garden' => [
                'Furniture',
                'Kitchen Appliances',
                'Garden Tools',
                'Home Decor',
                'Lighting'
            ],
            'Sports & Outdoors' => [
                'Fitness Equipment',
                'Outdoor Gear',
                'Team Sports',
                'Water Sports',
                'Winter Sports'
            ],
            'Books & Media' => [
                'Fiction Books',
                'Non-Fiction Books',
                'Movies & DVDs',
                'Music CDs',
                'E-books'
            ],
            'Health & Beauty' => [
                'Skincare',
                'Makeup',
                'Hair Care',
                'Personal Care',
                'Vitamins & Supplements'
            ],
            'Automotive' => [
                'Car Parts',
                'Car Electronics',
                'Motorcycle Parts',
                'Car Care',
                'Tools & Equipment'
            ]
        ];

        // Create subcategories
        foreach ($subcategories as $parentName => $subCats) {
            $parentCategory = $createdMainCategories[$parentName];
            foreach ($subCats as $subCatName) {
                ProductCategory::create([
                    'name' => $subCatName,
                    'parent_id' => $parentCategory->id
                ]);
            }
        }
    }
}
