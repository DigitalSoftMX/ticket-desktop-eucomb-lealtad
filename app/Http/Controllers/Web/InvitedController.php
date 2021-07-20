<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Web\SalesQr;
use App\Web\Station;
use Illuminate\Http\Request;

class InvitedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $namemonths = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $months = [];
        for ($i = 0; $i < (int)date('m'); $i++) {
            array_push($months, ['id' => ($i + 1 < 10 ? '0' : '') . ($i + 1), 'month' => $namemonths[$i]]);
        }
        $sales = SalesQr::where('reference', '!=', null)->get();
        $roles = Role::where('id', '<=', 4)->orWhere('id', 7)->get();
        $users = [];
        $reference = 0;
        foreach ($roles as $rol) {
            foreach ($rol->users as $user) {
                if ($count = $user->references->count() > 0) {
                    $reference += $count;
                    array_push($users, $user);
                }
            }
        }
        return view('invited.show', [
            'references' => $reference,
            'tickets' => $sales->count(),
            'liters' => number_format($sales->sum('liters'), 2),
            'pageSlug' => 'Invitados',
            'stations' => Station::all(),
            'months' => $months,
            'month' => date('m'),
            'users' => $users,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $invited)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $namemonths = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $months = [];
        for ($i = 0; $i < (int)date('m'); $i++) {
            array_push($months, ['id' => ($i + 1 < 10 ? '0' : '') . ($i + 1), 'month' => $namemonths[$i]]);
        }
        $rol = $invited->roles->first()->id;
        return view('invited.show', [
            'route' => $rol == 4 ? 'dispatchers.index' : 'admins.index',
            'invited' => $invited,
            'pageSlug' => $rol == 1 ? 'Administradores' : 'Despachadores',
            'stations' => Station::all(),
            'months' => $months,
            'month' => date('m')
        ]);
    }
    // Obtener las ventas de un cliente referido por station y mes
    public function getSales(Request $request, $station, $month, $invited = 0)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $query = [['station_id', $station], ['reference', '!=', null]];
        $invited != '0' ? array_push($query, ['reference', $invited]) : 0;
        $salesQr = SalesQr::where($query)->whereDate('created_at', 'like', '%' . date('Y') . '-' . $month . '%')->get();
        $salesQrs = [];
        foreach ($salesQr as $sq) {
            $data['role'] = $sq->_reference->username;
            $data['membership'] = $sq->client->user->username;
            $data['liters'] = number_format($sq->liters, 2);
            $data['points'] = $sq->points;
            $data['product'] = $sq->gasoline->name;
            $data['station'] = $sq->station->name;
            $data['data'] = $sq->created_at->format('Y/m/d H:i');
            array_push($salesQrs, $data);
        }
        return response()->json(['salesqrs' => $salesQrs]);
    }
}
