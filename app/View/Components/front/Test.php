<?php

namespace App\View\Components\front;

use Illuminate\View\Component;

class Test extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        // dd('win');
        return view('components.front.test');
    }
}
