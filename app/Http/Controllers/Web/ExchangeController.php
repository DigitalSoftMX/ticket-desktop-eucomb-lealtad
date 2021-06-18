<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Web\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion', 'admin_sales']);
        if (($user = Auth::user())->roles[0]->id == 3) {
            return view('exchanges.index', ['exchanges' => $user->admin->station->exchanges->where('status', '!=', 14)]);
        }
        if (($user = auth()->user())->roles->first()->id == 7) {
            return view('exchanges.index', ['exchanges' => $user->exchanges->where('statud', '!=', 14)]);
        }
        return view('exchanges.index', ['exchanges' => Exchange::where('status', '!=', 14)->get()]);
    }
    // Metodo para entregar de canje
    public function deliver(Request $request, Exchange $exchange)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $exchange->update(['status' => 12, 'admin_id' => Auth::user()->id]);
        $exchange->client->visits++;
        $exchange->client->save();
        return redirect()->back()->withStatus('El canje cambió a estado de entrega');
    }
    // Metodo para cobrer un canje
    public function collect(Request $request, Exchange $exchange)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $exchange->update(['status' => 13, 'admin_id' => Auth::user()->id]);
        return redirect()->back()->withStatus('El canje cambió a estado de cobro');
    }
    // Metodo para enviar a historial un canje
    public function history(Request $request, Exchange $exchange)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $exchange->update(['status' => 14, 'admin_id' => Auth::user()->id]);
        return redirect()->back()->withStatus('El canje cambió a estado de historial para el cliente');
    }
}
