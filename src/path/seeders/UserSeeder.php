<?php

namespace Authentication\path\seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'first_name'  => 'ریحانه',
            'last_name'   => 'ابراهیمی',
            'national_id' => '5350024159',
            'mobile'      => '09162491186',
            'password'    => Hash::make(123456789)
        ]);

        DB::table('users')->insert([
            'first_name'  => 'صادق',
            'last_name'   => 'روحانی',
            'national_id' => '0370899776',
            'mobile'      => '09136106086',
            'password'    => Hash::make(123456789)
        ]);
    }
}
