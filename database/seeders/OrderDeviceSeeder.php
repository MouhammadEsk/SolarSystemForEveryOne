<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeviceOrder;

class OrderDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeviceOrder::create([
            'device_id'=>1,
            'order_id'=>1,
            'ammount'=>9
        ]);
    }
}
