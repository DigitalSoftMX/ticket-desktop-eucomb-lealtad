<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Web\Sale;
use App\Web\AdminStation;
use App\Web\Station;

class UserHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion', 'admin_sales']);
        $user = auth()->user();
        if ($user->roles->first()->id == 3) {
            $admin_station = AdminStation::where('user_id', $user->id)->first();
            // return view('user_history.index', ['sales' => Sale::where('station_id', $admin_station->station_id)->get()]);
            return view('user_history.index', ['stations' => [$admin_station->station],]);
        }
        return view('user_history.index', ['stations' => Station::where('lealtad', true)->get(),]);
    }
    // Obtener la lista de despachadores segun la estacion seleccionada
    public function getDispatchers(Station $station)
    {
        $dispatchers = $station->dispatchers()->with("user:id,name,first_surname,second_surname")->get()->toArray();
        return response()->json(['dispatchers' => $dispatchers]);
    }
    // Obtener los movimientos por estacion, despachador y fecha
    public function getHistory(Request $request)
    {
        $query = [];
        $salesArray = [];
        if ($request->input('station'))
            array_push($query, ['station_id', $request->input('station')]);
        if ($request->input('dispatcher'))
            array_push($query, ['dispatcher_id', $request->input('dispatcher')]);
        if ($request->input('start') or $request->input('end')) {
            if ($request->input('start') and !$request->input('end')) {
                $sales = Sale::where($query)->whereDate('created_at', '>=', $request->input('start'))->with([
                    'dispatcher.user', 'gasoline', 'schedule', 'station', 'client.user'
                ])->get();
            }
            if (!$request->input('start') and $request->input('end')) {
                $sales = Sale::where($query)->whereDate('created_at', '<=', $request->input('end'))->with([
                    'dispatcher.user', 'gasoline', 'schedule', 'station', 'client.user'
                ])->get();
            }
            if ($request->input('start') and $request->input('end')) {
                $sales = Sale::where($query)->whereDate('created_at', '>=', $request->input('start'))
                    ->whereDate('created_at', '<=', $request->input('end'))->with([
                        'dispatcher.user', 'gasoline', 'schedule', 'station', 'client.user'
                    ])->get();
            }
        } else {
            $sales = Sale::where($query)->with([
                'dispatcher.user', 'gasoline', 'schedule', 'station', 'client.user'
            ])->get();
        }
        if ($sales) {
            foreach ($sales as $sale) {
                $data['dispatcher'] = '';
                if ($sale->dispatcher)
                    $data['dispatcher'] = $sale->dispatcher->user->username;
                $data['sale'] = $sale->sale;
                $data['gasoline'] = $sale->gasoline->name;
                $data['liters'] = number_format($sale->liters, 2);
                $data['payment'] = '$' . number_format($sale->payment, 2);
                $data['schedule'] = '';
                if ($sale->schedule)
                    $data['schedule'] = $sale->schedule->name;
                $data['station'] = $sale->station->name;
                $data['client'] = $sale->client->user->username;
                $data['island'] = $sale->no_island;
                $data['bomb'] = $sale->no_bomb;
                $data['date'] = $sale->created_at->format('Y-m-d H:i');
                array_push($salesArray, $data);
            }
        }
        return response()->json(['sales' => $salesArray,]);
    }
}
