<?php

namespace Authentication\path\seeders;

use App\Models\User;
use Authentication\path\models\ProvinceCity;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProvinceCitySeeder::class,
            // UserSeeder::class
        ]);
    }
}
