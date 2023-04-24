<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use Carbon\Carbon;


class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Appointment::create([
            'type'=>'installation',
            'status'=>'pending',
            'startTime'=>Carbon::create('2023', '01', '04'),
            'finishTime'=>Carbon::create('2023', '01', '07'),
            'days'=>4,
            'team_id'=>1,
            'order_id'=>1,
            'compane_id'=>1,
        ]);
    }
}
