<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\DispatcherRequest;
use App\Http\Requests\EditDispatcherRequest;
use App\User;
use App\Web\Dispatcher;
use App\Web\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
        $date = substr(Carbon::now()->format('Y'), 2);
        while (true) {
            $username = rand(10000, 99999);
            $username = 'D-' . $date . $username;
            if (!(User::where('username', $username)->exists())) {
                break;
            }
        }
        $user = User::create($request->merge(['password' => Hash::make($request->get('password')), 'username' => $username])->all());
        if ($station->id != null) {
            $request->merge(['station_id' => $station->id]);
        } else {
            $request->merge(['station_id' => $request->station_id]);
        }
        Dispatcher::create($request->merge(['user_id' => $user->id])->all());
        $user->roles()->attach(4);
        if ($station->id != null) {
            return redirect()->route('dispatcher.index', $station)->withStatus(__('Despachador creado con éxito'));
        }
        return redirect()->route('dispatchers.index')->withStatus(__('Despachador creado con éxito'));
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
    public function update(EditDispatcherRequest $request, Station $station, Dispatcher $dispatcher)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        if ($request->station_id != null) {
            $request->validate(['schedule_id' => 'required', 'island_id' => 'required']);
            $dispatcher->update($request->only('station_id', 'schedule_id', 'island_id'));
        }
        if ($station->id != null) {
            if ($request->schedule_id != null || $request->island_id != null) {
                $request->merge(['station_id' => $station->id]);
                if ($request->schedule_id == null) {
                    $request->merge(['schedule_id' => $dispatcher->user->schedule_id]);
                }
                if ($request->island_id == null) {
                    $request->merge(['island_id' => $dispatcher->user->island_id]);
                }
                $dispatcher->update($request->only('station_id', 'schedule_id', 'island_id'));
            }
        }
        if ($request->email != $dispatcher->user->email) {
            request()->validate(['email' => ['required', 'email', Rule::unique('users')->ignore($dispatcher->user->id)]]);
        }
        if ($request->sex == null) {
            $request->merge(['sex' => $dispatcher->user->sex]);
        }
        if ($request->password != null) {
            request()->validate(['password' => 'confirmed|min:6']);
            $request->merge(['password' => Hash::make($request->get('password'))]);
        } else {
            $request->merge(['password' => $dispatcher->user->password]);
        }
        $dispatcher->user->update($request->all());
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
        $dispatcher->user->delete();
        return redirect()->back()->withStatus(__('Despachador eliminado exitosamente.'));
    }
}