<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
            'user_id' => 1,
            'name' => 'Tシャツ',
            'brand' => 'ノーブランド',
            'price' => 3000,
            'img_url' => '/images/img/T-shirt_1.jpg',
            'description' => 'カラー：ホワイト\n新品\n即日発送可能',
            'category_id' => '1',
            'condition_id' => '1'
        ]);

        Item::create([
            'user_id' => 1,
            'name' => 'Tシャツ',
            'brand' => 'ノーブランド',
            'price' => 3000,
            'img_url' => '/images/img/T-shirt_2.jpg',
            'description' => 'カラー：ブラック\n新品\n購入後、１週間以内に発送',
            'category_id' => '1',
            'condition_id' => '1'
        ]);

        Item::create([
            'user_id' => 1,
            'name' => 'シューズ',
            'brand' => 'COMMON PROJECTS',
            'price' => 5000,
            'img_url' => '/images/img/shoes_1.jpg',
            'description' => 'カラー：グレー\n新品\n購入後、3日以内に発送',
            'category_id' => '2',
            'condition_id' => '1'
        ]);

        Item::create([
            'user_id' => 1,
            'name' => 'シューズ',
            'brand' => 'CONVERSE',
            'price' => 5000,
            'img_url' => '/images/img/shoes_2.jpg',
            'description' => 'カラー：ブラック\n新品\n即日発送可能',
            'category_id' => '2',
            'condition_id' => '1'
        ]);

        Item::create([
            'user_id' => 1,
            'name' => 'シューズ',
            'brand' => 'NIKE',
            'price' => 5000,
            'img_url' => '/images/img/shoes_3.jpg',
            'description' => 'カラー：グリーン\n新品\n即日発送可能',
            'category_id' => '2',
            'condition_id' => '1'
        ]);

        Item::create([
            'user_id' => 1,
            'name' => 'バッグ',
            'brand' => 'Gucci',
            'price' => 10000,
            'img_url' => '/images/img/bag_1.jpg',
            'description' => 'カラー：ブラック\n中古\n即日発送可能',
            'category_id' => '3',
            'condition_id' => '3'
        ]);

        Item::create([
            'user_id' => 1,
            'name' => 'バッグ',
            'brand' => 'SLOW',
            'price' => 10000,
            'img_url' => '/images/img/bag_2.jpg',
            'description' => 'カラー：ブラウンn新品\n購入後、3日以内に発送',
            'category_id' => '3',
            'condition_id' => '1'
        ]);

        Item::create([
            'user_id' => 1,
            'name' => 'バッグ',
            'brand' => 'ノーブランド',
            'price' => 10000,
            'img_url' => '/images/img/bag_3.jpg',
            'description' => 'カラー：ブルー\n新品\n購入後、１週間以内に発送',
            'category_id' => '3',
            'condition_id' => '1'
        ]);

        Item::create([
            'user_id' => 1,
            'name' => 'ブレスレット',
            'brand' => 'ノーブランド',
            'price' => 5000,
            'img_url' => '/images/img/bracelet.jpg',
            'description' => 'カラー：ブルー\n中古\n即日発送可能',
            'category_id' => '4',
            'condition_id' => '3'
        ]);

        Item::create([
            'user_id' => 1,
            'name' => 'ピアス',
            'brand' => 'SWAROVSKI',
            'price' => 10000,
            'img_url' => '/images/img/pierce.jpg',
            'description' => 'カラー：ブルー\n新品\n即日発送可能',
            'category_id' => '4',
            'condition_id' => '1'
        ]);
    }
}
