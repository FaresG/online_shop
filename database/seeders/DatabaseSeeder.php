<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $user = User::factory()->create([
             'name' => 'Fares Gdoura',
             'email' => 'gdourafares@gmail.com',
             'email_verified_at' => now(),
             'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
             'remember_token' => Str::random(10),
         ]);

         $discount = Discount::factory()->create([
             'name'=> 'BLACK_FRIDAY_2023',
             'description' => 'this is a discount of 50% use it before december 2023',
             'discount_percent' => 50,
             'active' => false
         ]);

         Product::factory(5)
             ->for($user)
             ->create();

    }
}
