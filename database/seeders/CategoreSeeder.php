<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categore;


class CategoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categore::create([
            'id'=>1,
            'name'=>'Category 1'
        ]);
        Categore::create([
            'id'=>2,
            'name'=>'Solar Panels'
        ]);
        Categore::create([
            'id'=>3,
            'name'=>'Inverters'
        ]);
        Categore::create([
            'id'=>4,
            'name'=>'Batteries'
        ]);
        Categore::create([
            'id'=>5,
            'name'=>'Electrical Generator'
        ]);
    }
}
