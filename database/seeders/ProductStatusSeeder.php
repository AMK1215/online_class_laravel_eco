<?php

namespace Database\Seeders;

use App\Models\Admin\ProductStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Active',
            'Inactive',
            'Draft',
            'Published',
            'Pending Approval',
            'Approved',
            'Rejected',
            'Out of Stock',
            'In Stock',
            'Limited Stock',
            'Discontinued',
            'Coming Soon',
            'Pre-Order',
            'Back Order',
            'Featured',
            'On Sale',
            'New Arrival',
            'Best Seller',
            'Clearance',
            'Seasonal',
            'Archived',
            'Under Review',
            'Suspended',
            'Recalled',
            'Damaged',
            'Refurbished',
            'Second Hand',
            'Vintage',
            'Limited Edition',
            'Exclusive'
        ];

        foreach ($statuses as $status) {
            ProductStatus::create([
                'name' => $status
            ]);
        }
    }
}
