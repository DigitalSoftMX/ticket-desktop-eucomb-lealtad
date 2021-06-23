<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MainGraphicsDashboard extends Component
{
    public $number;
    public $options;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($number, $options)
    {
        $this->number = $number;
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.main-graphics-dashboard');
    }
}
