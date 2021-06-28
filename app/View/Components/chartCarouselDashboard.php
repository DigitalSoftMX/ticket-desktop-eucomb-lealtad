<?php

namespace App\View\Components;

use Illuminate\View\Component;

class chartCarouselDashboard extends Component
{   
    protected $listeners = ['postAdded' => 'incrementPostCount'];
    public $mounts;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($mounts)
    {
        $this->mounts = $mounts;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.chart-carousel-dashboard');
    }

    public function incrementPostCount()
    {
        $this->mounts = ['enero','enero','enero','enero','enero','enero','enero','enero','enero','enero','enero','enero'];
    }

}
