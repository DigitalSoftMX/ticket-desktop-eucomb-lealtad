<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ChartCarouselDashboard extends Component
{
    public $mounts;
    public $m = 0;
    public $con = 1;
    public $title = 'click';
    //protected $listeners = ['postAdded' => 'incrementPostCount'];

    public function mount($mounts)
    {
        $this->mounts =  $mounts;
    }


    public function incrementPostCount()
    { 
        $this->m = 0;
        $this->title = 'hola';
        $this->con = 1;
        $this->mounts = ['enero','df','enero','ff','enero','ff','enero','ffff','enero','gg','enero','eee'];
    }

    protected function getListeners()
    {
        return ['postAdded' => 'incrementPostCount'];
    }

    public function render()
    {
        return view('livewire.chart-carousel-dashboard');
    }
}
