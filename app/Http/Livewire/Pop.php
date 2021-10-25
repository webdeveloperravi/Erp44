<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Pop extends Component
{
    public $show = 0;
    public $head = "";
    public $message = "";


    protected $listeners = [
        'pop'
    ];

    function pop($head, $message)
    {
        $this->head = $head;
        $this->message = $message;
        $this->show = 1;
    }

    function hide()
    {
        $this->show = 0;
    }

    public function render()
    {
        return view('livewire.pop');
    }
}
