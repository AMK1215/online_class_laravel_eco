<?php

namespace Database\Seeders;

use App\Models\Admin\Vendor;
use App\Models\Admin\VendorPayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = Vendor::all();

        if ($vendors->isEmpty()) {
            $this->command->warn('No vendors found. Skipping vendor payments seeding.');
            return;
        }

        $paymentMethods = ['credit_card', 'bank_transfer', 'paypal', 'stripe', 'check'];

        foreach ($vendors as $vendor) {
            // Create 5-15 payments for each vendor
            $paymentCount = rand(5, 15);
            
            for ($i = 0; $i < $paymentCount; $i++) {
                $amount = rand(100, 5000) + (rand(0, 99) / 100); // Random amount between 100.00 and 5000.99
                $paymentDate = now()->subDays(rand(1, 365)); // Random date within the last year
                $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
                
                VendorPayment::create([
                    'vendor_id' => $vendor->id,
                    'amount' => $amount,
                    'payment_date' => $paymentDate,
                    'payment_method' => $paymentMethod,
                    'created_at' => $paymentDate,
                    'updated_at' => $paymentDate,
                ]);
            }
        }

        $this->command->info('Vendor payments seeded successfully!');
    }
}
