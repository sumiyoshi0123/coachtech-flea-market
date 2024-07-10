<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Condition;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conditions = ['新品', '新品同様', '中古品'];

        foreach ($conditions as $condition) {
            Condition::create(['name' => $condition]);
        }
    }
}
