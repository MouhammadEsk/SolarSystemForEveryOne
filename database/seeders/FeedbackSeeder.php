<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feedback;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feedback::create([
            'title'=>'Suggestion',
            'message'=>'With Conversations, feedback can be requested and received by anyone at any time, and managers can use it to gather input and provide a more holistic view of their employees.',
            'compane_id'=>1,
            'user_id'=>1

        ]);
    }
}
