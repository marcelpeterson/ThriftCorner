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
            'first_name' => 'Marcel',
            'last_name' => 'Peterson',
            'email' => 'marcel.peterson@binus.ac.id',
            'phone' => '081212345678',
            'photo_url' => Avatar::create('Marcel Peterson')->toBase64(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'first_name' => 'Bryan',
            'last_name' => 'Law',
            'email' => 'bryan.law@binus.ac.id',
            'phone' => '081212345679',
            'photo_url' => Avatar::create('Wilbert Nevin')->toBase64(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'first_name' => 'Wilbert',
            'last_name' => 'Nevin',
            'email' => 'wilbert.lorenzo@binus.ac.id',
            'phone' => '081212345680',
            'photo_url' => Avatar::create('Wilbert Nevin')->toBase64(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'first_name' => 'George',
            'last_name' => 'Binsar',
            'email' => 'sitorus.tua@binus.ac.id',
            'phone' => '081212345681',
            'photo_url' => Avatar::create('George Binsar')->toBase64(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'first_name' => 'Raden',
            'last_name' => 'Althav',
            'email' => 'raden.himawan@binus.ac.id',
            'phone' => '081212345682',
            'photo_url' => Avatar::create('Raden Althav')->toBase64(),
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@thriftcorner.com',
            'phone' => '',
            'photo_url' => Avatar::create('Admin User')->toBase64(),
            'password' => Hash::make('@thr!ftC0rn3r'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
    }
}
