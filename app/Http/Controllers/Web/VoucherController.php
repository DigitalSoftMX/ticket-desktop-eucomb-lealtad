<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\VoucherRequest;
use App\Web\CatStatus;
use App\Web\CountVoucher;
use App\Web\Station;
use App\Web\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        if (($user = Auth::user())->roles[0]->id == 3) {
            return view('vouchers.index', ['vouchers' => $user->admin->station->vouchers, 'countvouchers' => $user->admin->station->ranges]);
        }
        return view('vouchers.index', ['vouchers' => Voucher::with(['station', 'station.ranges', 'status'])->get(), 'countvouchers' => CountVoucher::with(['station', 'estado'])->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('vouchers.create', ['status' => CatStatus::all(), 'stations' => Station::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VoucherRequest $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        $voucher = new Voucher();
        $voucher->create($request->all());
        return redirect()->route('vouchers.index')->with('status', 'Vale registrado correctamente');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Voucher $voucher)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('vouchers.edit', ['status' => CatStatus::all(), 'stations' => Station::all(), 'voucher' => $voucher]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VoucherRequest $request, Voucher $voucher)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        $voucher->update($request->all());
        return redirect()->route('vouchers.index')->withStatus('Vale actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Voucher $voucher)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        $voucher->delete();
        return redirect()->back()->withStatus('Se ha eliminado el vale correctamente');
    }
}
