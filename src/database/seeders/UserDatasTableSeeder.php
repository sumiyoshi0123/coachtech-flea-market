<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserData;

class UserDatasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserData::create([
            'user_id' => '2',
            'name' => 'Test',
            'post_number' => '123-4567',
            'address' => '東京都渋谷区千駄ヶ谷1-2-3',
            'building_name' => '千駄ヶ谷マンション101',
            'icon' => 'https://drive.google.com/file/d/15x_BAPwtgoIiGLFH91MoXsn-krrJ58d0/view?usp=drive_link'
        ]);
    }
}
