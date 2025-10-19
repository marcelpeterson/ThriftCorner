<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Laravolt\Avatar\Facade as Avatar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '081212345678',
            'photo_url' => Avatar::create('John Doe')->toBase64(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'phone' => '081212345679',
            'photo_url' => Avatar::create('Jane Smith')->toBase64(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'first_name' => 'Alice',
            'last_name' => 'Johnson',
            'email' => 'alice@example.com',
            'phone' => '081212345680',
            'photo_url' => Avatar::create('Alice Johnson')->toBase64(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'first_name' => 'Bob',
            'last_name' => 'Brown',
            'email' => 'bob@example.com',
            'phone' => '081212345681',
            'photo_url' => Avatar::create('Bob Brown')->toBase64(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'phone' => '081298765432',
            'photo_url' => Avatar::create('Admin User')->toBase64(),
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
    }
}
