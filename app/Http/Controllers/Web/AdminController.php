<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\UserRequest;
use App\Role;
use App\User;
use App\Web\AdminStation;
use App\Web\Empresa;
use App\Web\Exchange;
use App\Web\SalesQr;
use App\Web\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        $roles = Role::where('id', '<', 4)->orWhere('id', 7)->get();
        $admins = array();
        for ($i = (auth()->user()->roles->first()->id - 1); $i < count($roles); $i++) {
            foreach ($roles[$i]->users as $user) {
                if ($user->id != $request->user()->id) {
                    array_push($admins, $user);
                }
            }
        }
        return view('admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('admins.create', ['roles' => Role::where('id', '<', 4)->orWhere('id', 7)->get(), 'stations' => Station::where('lealtad', true)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        if ($request->rol == 3) {
            request()->validate(['station_id' => 'required']);
        }
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        while (true) {
            $username = substr(str_shuffle($permitted_chars), 0, 10);
            if (!(User::where('username', $username)->exists())) {
                $request->merge(['username' => $username]);
                break;
            }
        }
        $user = User::create($request->merge(['password' => bcrypt($request->password), 'active' => 1])->all());
        if ($request->rol == 3 || $request->rol == 2) {
            if ($request->station_id != null) {
                $request->merge(['user_id' => $user->id]);
                AdminStation::create($request->only(['user_id', 'station_id']));
            }
        }
        $user->roles()->sync($request->rol);
        return redirect()->route('admins.index')->withStatus(__('Administrador creado con éxito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $admin)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('admins.edit', ['admin' => $admin, 'roles' => Role::where('id', '<', 4)->orWhere('id', 7)->get(), 'stations' => Station::where('lealtad', true)->get()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $admin)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_sales']);

        // array meses en español
        $array_meses_espanol = [ "Jan" => "Enero","Feb" => "Febrero","Mar" => "Marzo","Apr" => "Abril","May" => "Mayo","Jun" => "Junio","Jul" => "Julio","Aug" => "Agosto","Sep" => "Septiembre","Oct" => "Octubre","Nov" => "Noviembre","Dec" => "Diciembre"];

        $array_meses_espanol_corto = [ "Jan" => "Ene", "Feb" => "Feb", "Mar" => "Mar", "Apr" => "Abr", "May" => "May", "Jun" => "Jun", "Jul" => "Jul", "Aug" => "Ago", "Sep" => "Sep", "Oct" => "Oct", "Nov" => "Nov", "Dec" => "Dic"];
        // array para los meses
        $array_meses = [];
        // array para los meses
        $array_meses_largos = [];

        $stations = Station::all();
        $dashboar = array();

        $meses_hasta_el_actual = [];

        //for para llenar el array con los meses hasta el actual
        for ($i = 1; $i <= 11; $i++) {
            array_push($meses_hasta_el_actual, date("Y-m", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))));
            array_push($array_meses, $array_meses_espanol_corto[strval(date("M", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))))]);
            array_push($array_meses_largos, $array_meses_espanol[strval(date("M", mktime(0, 0, 0, date("m") - $i, 28, date("Y"))))]);
        }

        array_unshift($meses_hasta_el_actual, date("Y-m", mktime(0, 0, 0, date("m"), 28, date("Y"))));
        array_unshift($array_meses,  $array_meses_espanol_corto[strval(date("M", mktime(0, 0, 0, date("m"), 28, date("Y"))))]);
        array_unshift($array_meses_largos,  $array_meses_espanol[strval(date("M", mktime(0, 0, 0, date("m"), 28, date("Y"))))]);
        

        $meses_hasta_el_actual = array_reverse($meses_hasta_el_actual);
        $array_meses = array_reverse($array_meses);
        //dd($array_meses_largos);

        // año select
        $year_select = [];
        $stations_year = [];
        $stations_mouths = [];
        $stations_mouths_tickets = [];
        $stations_mouths_exchage = [];

        for ($a = (date('Y') - 3); $a <= date('Y'); $a++) {
            array_push($year_select, $a);
        }

        $year_select = array_reverse($year_select);

        for ($mes = 0; $mes <= 11; $mes++) {
            foreach ($stations as $valor) {
                array_push($stations_mouths,  $request->user()->salesqrs()->where([['station_id', $valor->id],['created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%']])->sum('liters'));
                array_push($stations_mouths_tickets, $request->user()->salesqrs()->Where([['station_id', $valor->id],['created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%']])->count());
                array_push($stations_mouths_exchage, $request->user()->exchanges()->Where([['station_id', $valor->id],['status', 14],['created_at', 'like', '%' . $meses_hasta_el_actual[$mes] . '%']])->count());
            }
        }

        for($ai=0; $ai<4; $ai++){
            foreach ($stations as $valor) {
                array_push($stations_year, $request->user()->salesqrs()->where([['station_id', $valor->id],['created_at', 'like', '%' . $year_select[$ai] . '%']])->sum('liters'));
            }
        }

        $dashboar['liters_mouths'] = array_reverse(array_chunk($stations_mouths, 8));
        $dashboar['stations_mouths_tickets'] = array_reverse(array_chunk($stations_mouths_tickets, 8));
        $dashboar['stations_mouths_exchage'] = array_reverse(array_chunk($stations_mouths_exchage, 8));
        $dashboar['liters_year'] = array_chunk($stations_year,8);

        //dd( $dashboar['liters_mouths']);


        return view('admins.show',['userInfoSale' => $request,'estacion_dashboard' => $request->estacion_dashboard, 'stations' => $stations, 'year_select' => $year_select, 'array_meses' => $array_meses, 'array_meses_largos' => $array_meses_largos, 'dashboar' =>  $dashboar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $admin)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        if ($request->rol == 3) {
            request()->validate(['station_id' => 'required']);
            if ($admin->admin != null) {
                $admin->admin->update($request->only('station_id'));
            } else {
                $request->merge(['user_id' => $admin->id]);
                AdminStation::create($request->only(['user_id', 'station_id']));
            }
        }
        if ($request->password != null) {
            $admin->update(['password' => bcrypt($request->password)]);
        }
        $admin->update($request->except('password'));
        $admin->roles[0]->pivot->update(['role_id' => $request->rol]);
        return redirect()->route('admins.index')->withStatus(__('Administrador actualizado correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $admin)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        $admin->delete();
        return redirect()->route('admins.index')->withStatus(__('Administrador eliminado exitosamente.'));
    }
    // Metodo para obtener los horarios de una estacion
    public function getSchedules(Request $request)
    {
        $station = Station::find($request->station);
        return response()->json(['schedules' => $station->schedules, 'islands' => $station->islands]);
    }
    // Metoodo para obtener la informacion de la empresa
    public function editCompany(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('admins.company', ['company' => Empresa::find(1)]);
    }
    // Metodo para actualizar la informacion de la empresa
    public function updateCompany(CompanyRequest $request, Empresa $company)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        if ($request->file('logo')) {
            if (File::exists(public_path() . $company->imglogo)) {
                File::delete(public_path() . $company->imglogo);
            }
            $logo = $request->file('logo')->store('public');
            $request->merge(['imglogo' => Storage::url($logo)]);
        }
        $company->update($request->all());
        return redirect()->back()->withStatus(__('Datos guardados correctamente'));
    }
    // Método para el historial de puntos y canjes
    public function history(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_sales']);
        return view('admins.history');
    }
    // Metodo para obtener el historial de puntos
    public function getPoints(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_sales']);
        if (request('folio') != null || request('membresia') != null) {
            $queryPoints = $this->getQuery($request, 'sale');
            $queryExchange = $this->getQuery($request, 'exchange');
            if (request('start') != null && request('end') != null && request('start') <= request('end')) {
                $points = SalesQr::where([$queryPoints])->whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->with(['client.user', 'gasoline', 'station'])->get();
                $exchanges = Exchange::where([$queryExchange])->whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->with(['station', 'client.user', 'admin'])->get();
                return response()->json(['points' => $this->getQRs($points), 'exchanges' => $this->getExchanges($exchanges)]);
            }
            $points = SalesQr::where([$queryPoints])->with(['client.user', 'gasoline', 'station'])->get();
            $exchanges = Exchange::where([$queryExchange])->with(['station', 'client.user', 'admin'])->get();
            return response()->json(['points' => $this->getQRs($points), 'exchanges' => $this->getExchanges($exchanges)]);
        } else {
            if (request('start') == null || request('end') == null || request('start') > request('end')) {
                $request->merge(['start' => now()->format('Y-m-d'), 'end' => now()->format('Y-m-d')]);
            }
            $points = SalesQr::whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->with(['client.user', 'gasoline', 'station'])->get();
            $exchanges = Exchange::where('status', 14)->whereDate('created_at', '>=', $request->start)->whereDate('created_at', '<=', $request->end)->with(['station', 'client.user', 'admin'])->get();
            return response()->json(['points' => $this->getQRs($points), 'exchanges' => $this->getExchanges($exchanges)]);
        }
    }
    // Metodo para obtener un vector de consulta
    private function getQuery($request, $type)
    {
        $query = array();
        if ($request->folio != null) {
            array_push($query, ($type == 'exchange') ? [$type => request('folio'), 'status' => 14] : [$type => request('folio')]);
        }
        if ($request->membresia != null) {
            if (($user = User::where('username', $request->membresia)->first()) != null) {
                array_push($query, ($type == 'exchange') ? ['client_id' => $user->client->id, 'status' => 14] : ['client_id' => $user->client->id]);
            }
        }
        return $query;
    }
    // Metodo para obtener los canjes
    private function getExchanges($array)
    {
        $exchanges = array();
        foreach ($array as $exchange) {
            $data['folio'] = $exchange->exchange;
            $data['status'] = $exchange->estado->name;
            $data['station'] = $exchange->station->name;
            $data['membership'] = $exchange->client->user->username;
            $data['points'] = $exchange->points;
            $data['admin'] = ($exchange->admin ? $exchange->admin->name : '');
            $data['date'] = $exchange->created_at->format('Y/m/d H:i');
            array_push($exchanges, $data);
        }
        return $exchanges;
    }
    // Metodo para obtener los qr's
    private function getQRs($array)
    {
        $qrs = array();
        foreach ($array as $qr) {
            $data['membership'] = $qr->client->user->username;
            $data['sale'] = $qr->sale;
            $data['points'] = $qr->points;
            $data['liters'] = $qr->liters;
            $data['gasoline'] = ($qr->gasoline ? $qr->gasoline->name : '');
            $data['station'] = $qr->station->name;
            $data['date'] = $qr->created_at->format('Y/m/d H:i');
            array_push($qrs, $data);
        }
        return $qrs;
    }
}
