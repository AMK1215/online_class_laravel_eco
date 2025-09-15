<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in the correct order to maintain referential integrity
        $this->call([
            RolesTableSeeder::class,
            PermissionsTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UserTableSeeder::class,
            VendorSeeder::class,
            VendorSettingSeeder::class,
            VendorReviewSeeder::class,
            VendorPaymentSeeder::class,
            ProductCategorySeeder::class,
            ProductStatusSeeder::class,
            ProductSeeder::class,
        ]);

       
    }
}
