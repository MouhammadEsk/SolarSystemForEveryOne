<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Device;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Device::create([
            'name'=>'Device 1',
            'image'=>'http://127.0.0.1:5500/public/storage/Uploads/CompanyLogo/1665336905.jpg',
            'voltage'=>'1560',
            'voltagePower'=>'400',
            'FazesNumber'=>'2',
        ]);

    }
}
