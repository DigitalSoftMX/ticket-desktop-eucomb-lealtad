<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DetailsStationDashboard extends Component
{
    public $title;
    public $stations;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title,$stations)
    {
        $this->title = $title;
        $this->stations = $stations;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.details-station-dashboard');
    }
}
