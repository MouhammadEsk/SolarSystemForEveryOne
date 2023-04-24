<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([

            UserSeeder::class,
            CompanySeeder::class,
            TeamSeeder::class,
            PermissionSeeder::class,
            CategoreSeeder::class,
            FeatureSeeder::class,
            TypeSeeder::class,
            DeviceSeeder::class,
            FeedbackSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            OrderProductSeeder::class,
            OrderDeviceSeeder::class,
            AppointmentSeeder::class,

        ]);
    }
}
