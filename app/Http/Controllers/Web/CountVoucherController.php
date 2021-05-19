<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Web\CountVoucher;
use App\Web\Station;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountVoucherController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        try {
            if (Auth::user()->roles[0]->id == 3) {
                return view('countvouchers.create', ['min' => ((CountVoucher::all()->last()->max) + 1)]);
            }
            return view('countvouchers.create', ['stations' => Station::all(), 'min' => ((CountVoucher::all()->last()->max) + 1)]);
        } catch (Exception $e) {
            if (Auth::user()->roles[0]->id == 3) {
                return view('countvouchers.create', ['min' => 32701]);
            }
            return view('countvouchers.create', ['stations' => Station::all(), 'min' => 32701]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        request()->validate(['min' => 'required|Integer', 'max' => 'required|Integer', 'id_station' => 'required']);
        if ($request->max <= $request->min) {
            return redirect()->back()->withStatus('El número máximo debe ser mayor al mínimo');
        }
        if (CountVoucher::where('min', '>=', $request->min)->exists() || CountVoucher::where('max', '>=', $request->max)->exists()) {
            return redirect()->back()->withStatus('El número mínimo esta dentro de un rango ya registrado');
        }
        CountVoucher::create($request->merge(['status' => 4, 'remaining' => $request->max - $request->min])->all());
        return redirect()->route('vouchers.index')->withStatus('Se ha registrado el rango de vale correctamente');
    }
}
