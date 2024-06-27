<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create([
            'payment' => 'クレジットカード'
        ]);

        Payment::create([
            'payment' => '銀行振込'
        ]);

        Payment::create([
            'payment' => 'コンビニ払い'
        ]);
    }
}
