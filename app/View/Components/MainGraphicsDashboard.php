<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Web\Ticket;
use App\Web\SalesQr;


class MainGraphicsDashboard extends Component
{
    public $number;
    public $options;
    public $chart;
    public $stations;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($number, $stations)
    {   
        // año select
        $year_select = [];

        for ($a = (date('Y') - 4); $a <= date('Y'); $a++) {
            array_push($year_select, $a);
        }

        $year_select = array_reverse($year_select);

        $stations_year = [];
        for($ai=0; $ai<4; $ai++){
            foreach ($stations as $valor) {
                array_push($stations_year, SalesQr::where([['station_id', $valor->id],['created_at', 'like', '%' . $year_select[$ai] . '%']])->sum('liters') + Ticket::where([['descrip', 'puntos sumados'],['descrip', 'Puntos Dobles Sumados'],['created_at', 'like', '%' . $year_select[$ai] . '%'],['id_gas', $valor->id]])->sum('litro'));
            }
        }
        $this->stations = $stations;
        $this->chart =  array_chunk($stations_year,8);
        $this->number = $number;
        $this->options = $year_select;
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
