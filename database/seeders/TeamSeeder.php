<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Team::create([
            'name'=>'AboAbdo',
            'location'=>[
                'lat'=>1651,
                'long'=>4512
                ],
            'available'=>rand(0,1),
            'active'=>0,
            'phone'=>'0954566',
            'FinishAt'=>'2023-01-07',
            'email'=>'aboabdo@solar.com',
            'company_id'=>1,
            'password'=>Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
