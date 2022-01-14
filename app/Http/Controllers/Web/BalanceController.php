<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Web\Deposit;
use App\Http\Requests\BalanceRequest;
use App\Repositories\Actions;
use App\User;
use Illuminate\Http\Request;
use App\Web\Station;

class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion', 'admin_sales']);
        if ($station->id != null || auth()->user()->roles->first()->id == 3) {
            $station = $request->user()->station(auth()->user(), $station);
            return view('balance.index', ['deposits' => $station->deposits->where('status', '!=', 4), 'station' => $station]);
        }
        if (($user = auth()->user())->roles->first()->id == 1)
            return view('balance.index', ['deposits' => Deposit::where('status', '!=', 4)->with('client.user')->get()]);
        return view('balance.index', ['deposits' => $user->deposits->where('status', '!=', 4)]);
    }

    // Funcion para autorizar el abono
    public function acceptBalance(Request $request, Deposit $deposit)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $deposit->update(['status' => 2, 'deny' => null]);
        if ($balance = Deposit::where([['client_id', $deposit->client->id], ['station_id', $deposit->station_id], ['status', 4]])->first()) {
            $balance->balance += $deposit->balance;
            $balance->save();
        } else {
            Deposit::create([
                'client_id' => $deposit->client->id, 'balance' => $deposit->balance, 'image_payment' =>
                'Saldo disponible para cliente', 'station_id' => $deposit->station_id, 'status' => 4
            ]);
        }
        $notification = new Actions();
        $notification->sendNotification($deposit->client->ids, 'Su depósito ha sido aprobado');
        return redirect()->back()->withStatus(__('Abono autorizado'));
    }
    // Funcion para denegar el abono
    public function denyBalance(Request $request, Deposit $deposit, $estado = null)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        request()->validate(['deny' => 'required|string|min:3']);
        $deposit->update($request->merge(['status' => $estado ? 1 : 3])->only(['status', 'deny']));
        $notification = new Actions();
        $notification->sendNotification(
            $deposit->client->ids,
            'Su depósito ha sido aprobado',
            $estado ?
                'Su abono se colocó al estado pendiente' :
                'Su abono ha sido denegado',
            $request->deny
        );
        if ($estado) {
            if ($balance = Deposit::where([['client_id', $deposit->client->id], ['station_id', $deposit->station_id], ['status', 4]])->first()) {
                $balance->balance -= $deposit->balance;
                $balance->save();
            }
        }
        return $estado ? redirect()->back()->withStatus('Abono actualizado al estado pendiente') :
            redirect()->back()->withStatus(__('Abono denegado.'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        if ($station->id != null || auth()->user()->roles->first()->id == 3)
            return view('balance.create', ['station' => $request->user()->station(auth()->user(), $station)]);
        return view('balance.create', ['stations' => Station::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BalanceRequest $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        if ($station->id != null || auth()->user()->roles->first()->id == 3)
            $request->merge(['station_id' => ($request->user()->station(auth()->user(), $station))->id]);
        $user = User::where('username', $request->membership)->first();
        $request->merge(['client_id' => $user->client->id, 'image_payment' => $request->file('image')->store($user->username . '/' . $request->station_id, 'public'), 'status' => 1]);
        $deposit = Deposit::create($request->all());
        $this->acceptBalance($request, $deposit);
        return redirect()->route('balance.index')->withStatus(__('Abono Registrado correctamente.'));
    }
}
