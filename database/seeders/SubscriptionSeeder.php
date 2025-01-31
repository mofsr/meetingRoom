<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subscription::insert([
            ['plan_name' => 'Free Plan', 'max_bookings_per_day' => 3],
            ['plan_name' => 'Basic Plan', 'max_bookings_per_day' => 5],
            ['plan_name' => 'Advance Plan', 'max_bookings_per_day' => 7],
            ['plan_name' => 'Premium Plan', 'max_bookings_per_day' => 10],
        ]);
    }
}
