<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Web\Ticket;
use App\Web\SalesQr;

class ComparativeGraphDashboard extends Component
{
    public $mounts;
    public $stations;
    public $chart;
    public $num_months;
    public $year;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($mounts, $stations)
    {   
        $this->year = date("Y");
        $this->num_months = date('n');
        $this->mounts = $mounts;
        $this->stations = $stations;

        $mount_temp = strval(date('n')-1);

        if(date('n') < 10){
            $mount_temp = '0'.strval(date('n'));
        }


        $stations_year = [];
        for($ai=0; $ai<2; $ai++){
            foreach ($stations as $valor) {
                array_push($stations_year, SalesQr::where([['station_id', $valor->id],['created_at', 'like', '%' .($this->year - $ai).'-'.$mount_temp.'%']])->sum('liters') + Ticket::where([['descrip', 'puntos sumados'],['descrip', 'Puntos Dobles Sumados'],['created_at', 'like', '%' . ($this->year - $ai).'-'.$mount_temp.'%'],['id_gas', $valor->id]])->sum('litro'));
            }
        }

        $this->chart = array_chunk($stations_year,8);

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.comparative-graph-dashboard');
    }
}
