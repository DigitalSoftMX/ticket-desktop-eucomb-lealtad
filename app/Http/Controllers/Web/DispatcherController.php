<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\DispatcherRequest;
use App\User;
use App\Web\Dispatcher;
use App\Web\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DispatcherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        if ($station->id != null || Auth::user()->roles[0]->id == 3) {
            $station = $request->user()->station(Auth::user(), $station);
            return view('dispatchers.index', ['dispatchers' => $station->dispatchers, 'station' => $station]);
        }
        return view('dispatchers.index', ['dispatchers' => Dispatcher::all(), 'station' => $station]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        return view('dispatchers.create', ['stations' => Station::all(), 'station' => $station]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DispatcherRequest $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        while (true) {
            $username = substr(str_shuffle($permitted_chars), 0, 10);
            if (!(User::where('username', $username)->exists())) {
                $request->merge(['username' => $username]);
                break;
            }
        }
        $user = User::create($request->merge(['password' => bcrypt($request->password), 'username' => $username])->all());
        if ($station->id != null) {
            $request->merge(['station_id' => $station->id]);
        } else {
            $request->merge(['station_id' => $request->station_id]);
        }
        Dispatcher::create($request->merge(['user_id' => $user->id])->all());
        $user->roles()->attach(4);
        if ($station->id != null) {
            return redirect()->route('dispatcher.index', $station)->withStatus(__('Despachador registrado correctamente.'));
        }
        return redirect()->route('dispatchers.index')->withStatus(__('Despachador creado correctamente.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Station $station, Dispatcher $dispatcher)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        return view('dispatchers.edit', ['stations' => Station::all(), 'station' => $station, 'dispatcher' => $dispatcher]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DispatcherRequest $request, Station $station, Dispatcher $dispatcher)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        if ($station->id != null) {
            $request->merge(['station_id' => $station->id]);
        }
        $dispatcher->update($request->only('station_id', 'schedule_id', 'island_id'));
        if ($request->password != null) {
            request()->validate(['password' => 'confirmed|min:6']);
            $request->merge(['password' => bcrypt($request->password)]);
            $dispatcher->user->update($request->only('password'));
        }
        $dispatcher->user->update($request->except('password'));
        if ($station->id != null) {
            return redirect()->route('dispatcher.index', $station)->withStatus(__('Despachador actualizado correctamente'));
        }
        return redirect()->route('dispatchers.index')->withStatus(__('Despachador actualizado correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Dispatcher $dispatcher)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $dispatcher->user->update(['active' => 0]);
        return redirect()->back()->withStatus(__('Despachador eliminado exitosamente.'));
    }
}
