<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'test01@example.com',
            'password' => Hash::make('password123'), // パスワードをハッシュ化,
        ]);

        User::create([
            'email' => 'test02@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
