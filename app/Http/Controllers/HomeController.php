<?php

namespace App\Http\Controllers;

use App\Web\Station;
use App\Web\Client;
use App\Web\UserHistoryDeposit;
use App\Web\Exchange;
use App\Web\Ticket;
use App\Web\SalesQr;
use Illuminate\Http\Request;
use App\Web\AdminStation;
use App\User;
use App\Jobs\ProcessPodcast;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // set_time_limit(8000000);
        // Roles autorizados para el dashboard
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion', 'admin_sales']);

        // redireccionar al usuario admin_estacion
        if ($request->user()->roles[0]->name == 'admin_estacion') {
            $admin_station = AdminStation::where('user_id', $request->user()->id)->first();
            return redirect()->route('stations.show', ['station' => Station::find($admin_station->station_id), 'estacion_dashboard' => 'dashboard']);
        }elseif($request->user()->roles[0]->name == 'admin_sales'){
            return redirect()->route('admins.show',  ['admin' => $request->user()->id, 'estacion_dashboard' => 'dashboard']);
        }

        // array asociativo

        $dashboar = array();
        //$dashboar['nuevo']=array('portero'=>'lalo', 'defensa'=>'Terry', 'medio'=>'Lampard', 'delante'=>'Torres');


        // array meses en español
        $array_meses_espanol = [
            "Jan" => "Enero",
            "Feb" => "Febrero",
            "Mar" => "Marzo",
            "Apr" => "Abril",
            "May" => "Mayo",
            "Jun" => "Junio",
            "Jul" => "Julio",
            "Aug" => "Agosto",
            "Sep" => "Septiembre",
            "Oct" => "Octubre",
            "Nov" => "Noviembre",
            "Dec" => "Diciembre"
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
        // array para los meses
        $array_meses = [];
        // array para los meses
        $array_meses_largos = [];

        // arrays los litros por mes
        $litros_magna_meses = [];
        $litros_premium_meses = [];
        $litros_diesel_meses = [];
        //array con la suma de los meses
        $litros_total = [];
        // mes anterior 
        $mes_anterior = date('m', strtotime('-1 month'));
        $new_year = date('Y');
        if (date('m') == 01) {
            $new_year -= 1;
        }
        //array de todos los meses y sus ventas por estacion
        $meses_ventas_estacion = [];
        //array de las ventas por mes de las estaciones
        $meses_ventas = [];
        $suma_tem = 0;
        $suma_tem_final = 0;
        $suma_li_tem = [];
        // variable para sumar las ventas, ventas del mes actual y mes anterior
        $ventas_totales = 0;
        $ventas_totales_mes_actual = 0;
        $ventas_totales_mes_anterior = 0;
        $litros_mes_pasado = 0;
        $litros_mes_actual = 0;
        // modelos
        $stations = Station::all();

        $abonos_totales = UserHistoryDeposit::where('status', 1)->count();

        // conseguimos el total de clientes en la aplicación
        $clientes_totales = Client::all()->count();

        // conseguimos los clientes que se registraron este mes
        $clientes_mes_actual = Client::where('created_at', 'like', '%' . date('Y') . '-' . date('m') . '%')->count();
        $meses_hasta_el_actual = [];

        //for para llenar el array con los meses hasta el actual
        for ($i = 1; $i <= 11; $i++) {
            array_push($meses_hasta_el_actual, date("Y-m", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))));
            array_push($array_meses, $array_meses_espanol_corto[strval(date("M", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))))]);
            array_push($array_meses_largos, $array_meses_espanol[strval(date("M", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))))]);
        }

        array_unshift($meses_hasta_el_actual, date("Y-m", mktime(0, 0, 0, date("m"), 28, date("Y"))));
        array_unshift($array_meses,  $array_meses_espanol_corto[strval(date("M", mktime(0, 0, 0, date("m"), 28, date("Y"))))]);
        array_unshift($array_meses_largos,  $array_meses_espanol[strval(date("M", mktime(0, 0, 0, date("m"), 28, date("Y"))))]);

        // revertimos el orden del array
        $meses_hasta_el_actual = array_reverse($meses_hasta_el_actual);
        $array_meses = array_reverse($array_meses);

        // foreach para obtener la informacion de las estaciones
        foreach ($stations as $key => $station) {
            $ventas_totales_mes_actual += $station->sales()->where('created_at', 'like', '%' . date('Y') . '-' . date('m') . '%')->count();
            $ventas_totales_mes_anterior += $station->sales()->where('created_at', 'like', '%' . $new_year . '-' . $mes_anterior . '%')->count();
            // if que solo valida que haya informacion
            if ($station->sales != '[]') {
                //sumamos las ventas
                $ventas_totales += $station->sales()->count();
                // for que consigue los meses y las ventas de estos
                for ($mes = 0; $mes <= 11; $mes++) {
                    // este if solo completa el mes con un 0 si es menor a 10
                    if ($mes < 10) {
                        $mes_nuevo = '0' . $mes;
                    } else {
                        $mes_nuevo = $mes;
                    }
                    // consulta el tipo de gasolina por mes
                    $estaciones_m = $station->sales()->where('gasoline_id', '1')->whereDate('created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%')->sum('liters');
                    $estaciones_p = $station->sales()->where('gasoline_id', '2')->whereDate('created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%')->sum('liters');
                    $estaciones_d = $station->sales()->where('gasoline_id', '3')->whereDate('created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%')->sum('liters');
                    
                    array_push($litros_magna_meses, $estaciones_m);
                    array_push($litros_premium_meses, $estaciones_p);
                    array_push($litros_diesel_meses, $estaciones_d);
                    array_push($litros_total, $estaciones_m + $estaciones_p + $estaciones_d);
                    array_push($meses_ventas,  $estaciones_m + $estaciones_p + $estaciones_d);
                }
            } else {
                for ($mes = 0; $mes <= 11; $mes++) {
                    $litros_magna = 0;
                    array_push($meses_ventas, $litros_magna);
                }
            }
            array_push($meses_ventas_estacion, $meses_ventas);
            $meses_ventas = [];
            $estaciones_litros = $station->sales;
            foreach ($estaciones_litros as $estacion_litros) {
                $suma_tem += $estacion_litros->liters;
                $suma_tem_final += $estacion_litros->liters;
            }
            array_push($suma_li_tem, $suma_tem);
            $suma_tem = 0;
        }

        // if que valida que no haya cero 0 para realizar operaciones
        if ($ventas_totales_mes_anterior > 0) {
            $crecimiento = (($ventas_totales_mes_actual / $ventas_totales_mes_anterior) - 1) * 100;
        } else {
            $crecimiento = $ventas_totales_mes_actual * 100;
        }

        foreach ($meses_ventas_estacion as $total) {
            $litros_mes_pasado += $total[count($total) - 2];
            $litros_mes_actual += $total[count($total) - 1];
        }

        if ($litros_mes_pasado > 0) {
            $crecimiento_litros = number_format((($litros_mes_actual / $litros_mes_pasado) - 1) * 100, 2);
        } else {
            $crecimiento_litros = $litros_mes_pasado * 100;
        }


        $dashboar['tickets'] = Ticket::where('descrip', 'like', '%sumados%')->count() + SalesQr::all()->count();
        $dashboar['liters'] = SalesQr::all()->sum('liters') + Ticket::where('descrip', 'like', '%sumados%')->sum('litro');
        $dashboar['exchange'] = Exchange::where('status', 14)->count();

        // año select
        $year_select = [];

        for ($a = (date('Y') - 4); $a <= date('Y'); $a++) {
            array_push($year_select, $a);
        }

        $year_select = array_reverse($year_select);


        // array ultimos 12 meses de todas las estaciones
        $stations_mouths = [];
        $stations_mouths_tickets = [];
        $stations_mouths_exchage = [];

        for ($mes = 0; $mes <= 11; $mes++) {
            foreach ($stations as $valor) {
                array_push($stations_mouths, SalesQr::where([['station_id', $valor->id],['created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%']])->sum('liters') + Ticket::where([['descrip', 'puntos sumados'],['descrip', 'Puntos Dobles Sumados'],['created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%'],['id_gas', $valor->id]])->sum('litro'));
                array_push($stations_mouths_tickets, Ticket::Where([['id_gas', $valor->id],['descrip', 'puntos sumados'],['created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%']])->count() + Ticket::Where([['id_gas', $valor->id],['descrip', 'Puntos Dobles Sumados'],['created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%']])->count() + SalesQr::Where([['station_id', $valor->id],['created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%']])->count());
                array_push($stations_mouths_exchage, Exchange::Where([['station_id', $valor->id],['status', 14],['created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%']])->count());
            }
        }

        $dashboar['liters_mouths'] = array_reverse(array_chunk($stations_mouths, 8));
        $dashboar['stations_mouths_tickets'] = array_reverse(array_chunk($stations_mouths_tickets, 8));
        $dashboar['stations_mouths_exchage'] = array_reverse(array_chunk($stations_mouths_exchage, 8));


        return view('dashboard', compact('dashboar', 'stations', 'array_meses', 'array_meses_largos', 'litros_magna_meses', 'litros_premium_meses', 'litros_diesel_meses', 'litros_total', 'meses_ventas_estacion', 'suma_li_tem', 'suma_tem_final', 'clientes_totales', 'ventas_totales', 'abonos_totales', 'clientes_mes_actual', 'ventas_totales_mes_actual', 'crecimiento', 'crecimiento_litros', 'year_select'));
    }

    public function litersMountYears(Request $request)
    {
        
        $stations = Station::all();
        $stations_year = [];

        $one = $request->mountOne;
        $two = $request->mountTwo;

        if($one < 10){
            $one = '0'.$one;
        }

        if($two < 10){
            $two = '0'.$two;
        }

        foreach ($stations as $valor) {
            array_push($stations_year, number_format(SalesQr::where([['station_id', $valor->id],['created_at', 'like', '%' .date('Y').'-'.$one.'%']])->sum('liters') + Ticket::where([['descrip', 'puntos sumados'],['descrip', 'Puntos Dobles Sumados'],['created_at', 'like', '%' . date('Y').'-'.$one.'%'],['id_gas', $valor->id]])->sum('litro'),2));
        }

        foreach ($stations as $valor) {
            array_push($stations_year, number_format(SalesQr::where([['station_id', $valor->id],['created_at', 'like', '%' .(date('Y')-1).'-'.$two.'%']])->sum('liters') + Ticket::where([['descrip', 'puntos sumados'],['descrip', 'Puntos Dobles Sumados'],['created_at', 'like', '%' . (date('Y')-1).'-'.$two.'%'],['id_gas', $valor->id]])->sum('litro'),2));
        }

        return response()->json([ 'chartYears' => array_chunk($stations_year,8)]);
       
    }
}
