<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'full_name' => 'Test User',
            'email'    => 'test@example.com',
            'phone'    => '09120000000',
            'password' => Hash::make('123456'),
        ]);
    }
}
