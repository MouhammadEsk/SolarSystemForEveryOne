<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feature::create([
            'name'=>'Type',
            'type'=>'Text',
            'suffix'=>0,
            'categore_id'=>4
        ]);

        Feature::create([
            'name'=>'Ambeer',
            'type'=>'number',
            'suffix'=>'A',
            'categore_id'=>4
        ]);
        Feature::create([
            'name'=>'Voltage',
            'type'=>'number',
            'suffix'=>'Volt',
            'categore_id'=>4
        ]);
        Feature::create([
            'name'=>'Wattage',
            'type'=>'number',
            'suffix'=>'watt',
            'categore_id'=>2
        ]);
        Feature::create([
            'name'=>'totalWatt',
            'type'=>'number',
            'suffix'=>'watt',
            'categore_id'=>3
        ]);
        Feature::create([
            'name'=>'totalWattOnPower',
            'type'=>'number',
            'suffix'=>'watt',
            'categore_id'=>3
        ]);

    }
}
