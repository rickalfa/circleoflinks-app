<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Agent;
use App\Models\UserApp;
use App\Models\Conversation;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users_id = array();
        
        $users = UserApp::all();

        foreach ($users as $user) {
            
            array_push($users_id, $user->id);

        }

        $count_users = count($users_id);

        $agents_id = array();

        $Agents = Agent::all();



        foreach ($Agents as $agent) {
        
            array_push($agents_id, $agent->id);


        }


        Conversation::create([
            'message'=> "mensaje",
            'user_id'=> $users_id[0],
            'agent_id'=> $agents_id[0]

        ]);

        



    }
}
