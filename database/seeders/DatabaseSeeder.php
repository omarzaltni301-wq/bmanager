<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Price;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Promote anaskor03@gmail.com to admin
        $admin = User::where('email', 'anaskor03@gmail.com')->first();
        if ($admin) {
            $admin->update(['is_admin' => true]);
        }

        // Add default prices if table is empty
        if (Price::count() == 0) {
            $prices = [
                ['category' => 'Food', 'name' => 'Bread (1 loaf)', 'price' => '0.190 TND', 'type' => 'green'],
                ['category' => 'Food', 'name' => 'Milk (1L)', 'price' => '1.350 TND', 'type' => 'green'],
                ['category' => 'Food', 'name' => 'Eggs (15)', 'price' => '4.500 TND', 'type' => 'orange'],
                ['category' => 'Food', 'name' => 'Rice (1kg)', 'price' => '2.800 TND', 'type' => 'orange'],

                ['category' => 'Fuel', 'name' => 'Gasoline (1L)', 'price' => '2.525 TND', 'type' => 'green'],
                ['category' => 'Fuel', 'name' => 'Diesel (1L)', 'price' => '2.205 TND', 'type' => 'green'],

                ['category' => 'Electricity', 'name' => 'Low Consumption', 'price' => '0.200 TND', 'type' => 'green'],
                ['category' => 'Electricity', 'name' => 'Medium Consumption', 'price' => '0.300 TND', 'type' => 'green'],
                ['category' => 'Electricity', 'name' => 'High Consumption', 'price' => '0.500 TND', 'type' => 'green'],
            ];

            foreach ($prices as $p) {
                Price::create($p);
            }
        }
    }
}
