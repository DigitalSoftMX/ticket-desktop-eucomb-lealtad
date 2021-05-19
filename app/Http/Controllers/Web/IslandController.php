<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Web\Island;
use App\Web\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IslandController extends Controller
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
        return view('islands.index', ['islands' => $station->islands, 'station' => $station]);
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
        return view('islands.create', compact('station'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Station $station)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        $request->merge(['station_id' => $station->id]);
        Island::create(request()->validate(['station_id' => 'required', 'island' => 'required', 'bomb' => 'required']));
        return redirect()->route('islands.index', $station)->withStatus('Isla y bomba registrados correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Station $station, Island $island)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        return view('islands.edit', compact('station', 'island'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Station $station, Island $island)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        $request->merge(['station_id' => $station->id]);
        $island->update(request()->validate(['station_id' => 'required', 'island' => 'required', 'bomb' => 'required']));
        return redirect()->route('islands.index', $station)->withStatus('Isla y bomba actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Station $station, Island $island)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $station = $request->user()->station(Auth::user(), $station);
        $island->delete();
        return redirect()->route('islands.index', $station)->withStatus('Isla y bomba elimindos correctamente');
    }
}
