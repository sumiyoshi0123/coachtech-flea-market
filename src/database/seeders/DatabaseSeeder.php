<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ItemsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserDatasTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
    }
}