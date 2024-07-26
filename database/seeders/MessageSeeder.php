<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Conversation;
use App\Models\Message;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $Conversation = Conversation::findOrFail(1);


        for ($i=0; $i <= 5; $i++) { 
        
            Message::create([
                'conversation_id' => $Conversation->id,
                'sender_type' => "user",
                'sender_id'=> $Conversation->user_id,
                'content' =>"mensaje de ". $Conversation->user_id,

            ]);

            Message::create([
                'conversation_id' => $Conversation->id,
                'sender_type' => "agent",
                'sender_id'=> $Conversation->agent_id,
                'content' =>"mensaje de Bot ". $Conversation->agent_id,
                
            ]);


        }






    }
}
