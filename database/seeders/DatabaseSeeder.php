<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory(10)->create();
//
//         User::factory()->create([
//             'name' => fake()->name(),
//             'email' => fake()->email(),
//             'token' => fake()->md5(),
//         ]);
    }
}
