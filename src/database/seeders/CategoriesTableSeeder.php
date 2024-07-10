<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['洋服', '靴', 'バッグ', 'アクセサリー'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
