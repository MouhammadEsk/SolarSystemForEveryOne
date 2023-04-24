<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'total_voltage'=>'15000',
            'total_price'=>'7500.000',
            'hours_on_charge'=>'2',
            'hours_on_bettary'=>'4',
            'space'=>'50 M',
            'location'=>'5755',
            'user_id'=>1,

        ]);
    }
}
