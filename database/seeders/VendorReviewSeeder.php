<?php

namespace Database\Seeders;

use App\Models\Admin\Vendor;
use App\Models\Admin\VendorReview;
use App\Models\User;
use App\Enums\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = Vendor::all();
        $players = User::where('type', UserType::Player->value)->get();

        if ($vendors->isEmpty() || $players->isEmpty()) {
            $this->command->warn('No vendors or players found. Skipping vendor reviews seeding.');
            return;
        }

        $reviews = [
            [
                'rating' => 5,
                'comment' => 'Excellent service! The team delivered exactly what we needed on time and within budget. Highly recommended!',
            ],
            [
                'rating' => 4,
                'comment' => 'Great work overall. Communication was good and the final product met our expectations. Would work with them again.',
            ],
            [
                'rating' => 5,
                'comment' => 'Outstanding quality and professionalism. They went above and beyond our requirements. Fantastic experience!',
            ],
            [
                'rating' => 3,
                'comment' => 'Good work but there were some delays in delivery. The final result was satisfactory though.',
            ],
            [
                'rating' => 4,
                'comment' => 'Very professional team. They understood our needs well and delivered a solid solution. Good value for money.',
            ],
            [
                'rating' => 5,
                'comment' => 'Amazing experience working with this vendor. They are experts in their field and deliver exceptional results.',
            ],
            [
                'rating' => 4,
                'comment' => 'Reliable and professional service. The team was responsive and delivered quality work. Recommended!',
            ],
            [
                'rating' => 3,
                'comment' => 'Decent work but communication could have been better. The end result was acceptable.',
            ],
            [
                'rating' => 5,
                'comment' => 'Top-notch service! They exceeded our expectations and delivered outstanding results. Will definitely hire again!',
            ],
            [
                'rating' => 4,
                'comment' => 'Very satisfied with the work. The team was professional and delivered on time. Good experience overall.',
            ],
        ];

        foreach ($vendors as $vendor) {
            // Create 3-8 reviews for each vendor
            $reviewCount = rand(3, 8);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $review = $reviews[array_rand($reviews)];
                $player = $players->random();
                
                VendorReview::create([
                    'vendor_id' => $vendor->id,
                    'user_id' => $player->id,
                    'rating' => $review['rating'],
                    'comment' => $review['comment'],
                    'created_at' => now()->subDays(rand(1, 90)),
                    'updated_at' => now()->subDays(rand(1, 90)),
                ]);
            }
        }

        $this->command->info('Vendor reviews seeded successfully!');
    }
}
