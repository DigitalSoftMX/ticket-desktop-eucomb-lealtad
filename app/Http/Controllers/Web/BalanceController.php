<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Web\UserHistoryDeposit;
use App\Http\Requests\BalanceRequest;
use App\User;
use Illuminate\Http\Request;
use App\Web\Station;
use Illuminate\Support\Facades\Auth;

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
        if ($station->id != null || Auth::user()->roles[0]->id == 3) {
            $station = $request->user()->station(Auth::user(), $station);
            return view('balance.index', ['payments' => $station->deposits->where('status', '!=', 4), 'station' => $station]);
        }
        if (($user = auth()->user())->roles->first()->id == 1)
            //dd('si');
            return view('balance.index', ['payments' => UserHistoryDeposit::where('status', '!=', 4)->get()]);
        //return view('balance.index', ['payments' => $user->deposits->where('status', '!=', 4)]);
    }

    // Funcion para autorizar el abono
    public function acceptBalance(Request $request, UserHistoryDeposit $deposit)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $deposit->update(['status' => 2]);
        if (($balance = UserHistoryDeposit::where([['client_id', $deposit->client->id], ['station_id', $deposit->station_id], ['status', 4]])->first()) != null) {
            $balance->balance += $deposit->balance;
            $balance->save();
        } else {
            UserHistoryDeposit::create(['client_id' => $deposit->client->id, 'balance' => $deposit->balance, 'image_payment' => 'Saldo disponible para cliente', 'station_id' => $deposit->station_id, 'status' => 4]);
        }
        $this->makeNotification($deposit->client->ids, 'Su abono ha sido aprobado');
        return redirect()->back()->withStatus(__('Abono autorizado'));
    }
    // Funcion para denegar el abono
    public function denyBalance(Request $request, UserHistoryDeposit $deposit)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $deposit->update(['status' => 3]);
        $this->makeNotification($deposit->client->ids, 'Su abono ha sido denegado');
        return redirect()->back()->withStatus(__('Abono denegado.'));
    }
    // Funcion para enviar un notificacion al cliente
    private function makeNotification($ids, $status)
    {
        $fields = array(
            'app_id' => "62450fc4-bb2b-4f2e-a748-70e8300c6ddb",
            'contents' => array(
                "en" => "English message from postman",
                "es" => $status
            ),
            'headings' => array(
                "en" => "English title from postman",
                "es" => "Abonos Eucomb"
            ),
            'include_player_ids' => [$ids],
        );
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        if ($station->id != null || Auth::user()->roles[0]->id == 3) {
            return view('balance.create', ['station' => $request->user()->station(Auth::user(), $station)]);
        }
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
        if ($station->id != null || Auth::user()->roles[0]->id == 3) {
            $request->merge(['station_id' => ($request->user()->station(Auth::user(), $station))->id]);
        }
        $user = User::where('username', $request->membership)->first();
        $request->merge(['client_id' => $user->client->id, 'image_payment' => $request->file('image')->store($user->username . '/' . $request->station_id, 'public'), 'status' => 1]);
        $deposit = UserHistoryDeposit::create($request->all());
        $this->acceptBalance($request, $deposit);
        return redirect()->route('balance.index')->withStatus(__('Abono Registrado correctamente.'));
    }
}
