<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StationRequest;
use App\Web\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Web\Exchange;
use App\Web\Ticket;
use App\Web\SalesQr;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('stations.index', ['stations' => Station::where('lealtad', true)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('stations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StationRequest $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        request()->validate(['lealtad' => 'required', 'station' => 'required|image']);
        $image = $request->file('station')->store('public');
        $request->merge(['image' => Storage::url($image), 'id_empresa' => 1, 'id_type' => 1, 'active' => 1]);
        Station::create($request->all());
        return redirect()->route('stations.index')->withStatus('Estacion registrada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);

        $station_show = array();

        $array_meses_espanol = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ];

        $array_meses_espanol_corto = [
            "Jan" => "Ene",
            "Feb" => "Feb",
            "Mar" => "Mar",
            "Apr" => "Abr",
            "May" => "May",
            "Jun" => "Jun",
            "Jul" => "Jul",
            "Aug" => "Ago",
            "Sep" => "Sep",
            "Oct" => "Oct",
            "Nov" => "Nov",
            "Dec" => "Dic"
        ];

        $array_meses_numero = [
            "01",
            "02",
            "03",
            "04",
            "05",
            "06",
            "07",
            "08",
            "09",
            "10",
            "11",
            "12"
        ];

        // array para los meses
        $array_meses = [];
        $array_meses_largos = [];
        $meses_hasta_el_actual = [];

        //for para llenar el array con los meses hasta el actual
        for ($i = 1; $i <= 11; $i++) {
            array_push($meses_hasta_el_actual, date("Y-m", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))));
            array_push($array_meses, $array_meses_espanol_corto[strval(date("M", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))))]);
            //array_push($array_meses_largos, $array_meses_espanol[strval(date("M", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))))]);
        }

        array_unshift($meses_hasta_el_actual, date("Y-m", mktime(0, 0, 0, date("m"), 28, date("Y"))));
        array_unshift($array_meses,  $array_meses_espanol_corto[strval(date("M", mktime(0, 0, 0, date("m"), 28, date("Y"))))]);
        //array_unshift($array_meses_largos,  $array_meses_espanol[strval(date("M", mktime(0, 0, 0, date("m"), 28, date("Y"))))]);

        $station_show['meses'] = array_reverse($array_meses);
        $station_show['meses_largos'] = $array_meses_espanol;
        $meses_hasta_el_actual = array_reverse($meses_hasta_el_actual);
        
      
        $station = $request->user()->station(Auth::user(), $station);
        //dd($station->exchanges->count());
        //dd(Ticket::where('id_gas',$station->id)->where('descrip', 'puntos sumados')->count() + Ticket::where('id_gas',$station->id)->where('descrip', 'Puntos Dobles Sumados')->count() + SalesQr::where('station_id',$station->id)->count());
        $mes_anterior = date('m', strtotime('-1 month'));
        $mes_actual = date('m');
        $year = date('Y');

        $lastMont = $station->sales()->where('created_at', 'like', '%' . $year . '-' . $mes_anterior . '%')->sum('liters');
        $actualMont = $station->sales()->where('created_at', 'like', '%' . $year . '-' . $mes_actual . '%')->sum('liters');

        if ($lastMont > 0) {
            $liters = number_format((($actualMont / $lastMont) - 1) * 100, 2);
        } else {
            $liters = $lastMont * 100;
        }

        $lastMontSales = $station->sales()->where('created_at', 'like', '%' . $year . '-' . $mes_anterior . '%')->count();
        $actualMontSales = $station->sales()->where('created_at', 'like', '%' . $year . '-' . $mes_actual . '%')->count();

        if ($lastMontSales > 0) {
            $sales = number_format((($actualMontSales / $lastMontSales) - 1) * 100, 2);
        } else {
            $sales = $lastMontSales * 100;
        }

        // ventas de producto
        $total_magna = $station->sales()->where('gasoline_id', '1')->sum('liters');
        $total_premium = $station->sales()->where('gasoline_id', '2')->sum('liters');
        $total_diesel = $station->sales()->where('gasoline_id', '3')->sum('liters');


        $station_show['tickets'] = Ticket::where([['id_gas',$station->id], ['descrip', 'like','%sumados%']])->count() + SalesQr::where('station_id', $station->id)->count();
        $station_show['liters'] = Ticket::where([['id_gas',$station->id], ['descrip', 'like','%sumados%']])->sum('litro') + SalesQr::where('station_id', $station->id)->sum('liters');
        $station_mouths_magna = [];
        $station_mouths_premium = [];
        $station_exchange_mounths_1 = [];
        $station_tickets_mounths_1 = [];

        for($mes=0; $mes<=11; $mes++){
            array_push($station_mouths_magna, Ticket::where([['id_gas','=',$station->id],['producto', '=','magna'],['descrip', 'like','%sumados%'],['created_at', 'like', '%'.$meses_hasta_el_actual[$mes].'%']])->sum('litro') + SalesQr::where([['station_id', '=',$station->id],['gasoline_id','=', 1],['created_at', 'like', '%'.$meses_hasta_el_actual[$mes].'%']])->sum('liters'));
            array_push($station_mouths_premium, Ticket::where([['id_gas','=',$station->id],['producto', '=','premium'],['descrip', 'like','%sumados%'],['created_at', 'like', '%'.$meses_hasta_el_actual[$mes].'%']])->sum('litro') + SalesQr::where([['station_id', '=',$station->id],['gasoline_id','=', 2],['created_at', 'like', '%'.$meses_hasta_el_actual[$mes].'%']])->sum('liters'));
        }

        for($yearN=0; $yearN<3; $yearN++){
            for($mes=0; $mes<=11; $mes++){
                array_push($station_exchange_mounths_1, Exchange::where([['station_id',$station->id],['status',14],['created_at', 'like', '%'.(((int)$year) - $yearN).'-'.$array_meses_numero[$mes].'%']])->count());
                array_push($station_tickets_mounths_1, Ticket::where([['id_gas','=',$station->id],['descrip', 'like', '%sumados%'],['created_at', 'like', '%'.(((int)$year) - $yearN).'-'.$array_meses_numero[$mes].'%']])->count() + SalesQr::where([['station_id', '=',$station->id],['created_at', 'like', '%'.(((int)$year) - $yearN).'-'.$array_meses_numero[$mes].'%']])->count());
            }
        }

        //dd(array_chunk($station_exchange_mounths_1, 12));
        
        $station_show['magna'] = $station_mouths_magna;
        $station_show['premium'] = $station_mouths_premium;
        $station_show['vales_meses'] = array_chunk($station_exchange_mounths_1, 12);
        $station_show['tickets_meses'] = array_chunk($station_tickets_mounths_1,12);


        return view('stations.show', ['station_show' => $station_show,'station' => $station, 'liters' => $liters, 'sales' => $sales, 'estacion_dashboard' => $request->estacion_dashboard, 'total_magna' => $total_magna, 'total_premium' => $total_premium, 'total_diesel' => $total_diesel]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('stations.edit', compact('station'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StationRequest $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        if ($request->file('station')) {
            request()->validate(['station' => 'image']);
            if (File::exists(public_path() . $station->image)) {
                File::delete(public_path() . $station->image);
            }
            $logo = $request->file('station')->store('public');
            $request->merge(['image' => Storage::url($logo)]);
        }
        $station->update($request->all());
        return redirect()->route('stations.index')->withStatus('Estación actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        if (File::exists(public_path() . $station->image)) {
            File::delete(public_path() . $station->image);
        }
        $station->delete();
        return redirect()->route('stations.index')->withStatus('Se ha eliminado la estación');
    }
}
