<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\UserApp;
use App\Models\Whatsappservice\lead;

use Carbon\Carbon;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $users = UserApp::all();

        foreach ($users as $user) {
            Lead::create([
                'user_id' => $user->id,
                'name' => "default name",
                'phone_number' => '123456789',
                'last_message_time' => Carbon::now()->subMinutes(rand(1, 60)),
            ]);
        }

    }
}
