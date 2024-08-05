<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ChatLeads extends Component
{


    public $Conversations;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($conversations)
    {

        $this->Conversations = $conversations;
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.chat-leads');
    }
}
