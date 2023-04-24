<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Compane;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Compane::create([
            'name'=>'SolarSystemForEveryOne',
            'email'=>'solar@gmail.com',
            'password'=>Hash::make('password'),
            'phone'=>'0954565826',
            'logo'=>'logourl',
            'active'=>0,
            'location'=>[
                'lat'=>1234,
                'long'=>5678,
                'area'=>'damascus'],
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
