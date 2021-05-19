<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Web\Schedule;
use Illuminate\Http\Request;
use App\Web\Station;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        return view('schedules.index', ['schedules' => $station->schedules, 'station' => $station]);
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
        return view('schedules.create', compact('station'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        $request->merge(['station_id' => $station->id]);
        // falta validacion por si el turno ya existe o causa conflicto en el rango de tiempo con otro
        Schedule::create($request->all());
        return redirect()->route('schedules.index', $station)->withStatus('Turno registrado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Station $station, Schedule $schedule)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        return view('schedules.edit', compact('station', 'schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleRequest $request, Station $station, Schedule $schedule)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        $schedule->update($request->merge(['station_id' => $station->id])->all());
        return redirect()->route('schedules.index', $station)->withStatus('Turno actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Station $station, Schedule $schedule)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $schedule->delete();
        return redirect()->back()->withStatus('Turno eliminado correctamente');
    }
}
