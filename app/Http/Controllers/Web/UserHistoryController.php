<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Web\DispatcherHistoryPayment;
use App\Web\AdminStation;

class UserHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion', 'admin_sales']);
        if (count($request->user()->roles) > 1) {
            return view('user_history.index', ['sales' => DispatcherHistoryPayment::all()]);
        } else {
            if ($request->user()->roles[0]->id == 3) {
                $admin_station = AdminStation::where('user_id', $request->user()->id)->first();
                return view('user_history.index', ['sales' => DispatcherHistoryPayment::where('station_id', $admin_station->station_id)->get()]);
            } else {
                return view('user_history.index', ['sales' => DispatcherHistoryPayment::all()]);
            }
        }
    }
}
