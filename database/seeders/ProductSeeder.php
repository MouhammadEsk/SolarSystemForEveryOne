<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name'=>'Inverter k25',
            'categore_id'=>1,
            'image'=>'http://127.0.0.1:5500/public/storage/Uploads/Products/1665336905.jpg',
             'price'=>'250$',
             'available'=>1,
        ]);
    }
}
