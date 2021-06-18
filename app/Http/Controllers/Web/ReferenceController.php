<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\User;
use App\Web\Client;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('hosts.index', ['clients' => Client::where('active', 1)->with('user')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('hosts.create');
    }

    // Agregar usuario que referieren
    public function addReference(Request $request, User $reference, User $user)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        $reference->hosts()->attach($user->client->id);
        return redirect()->route('references.show', $reference)->withStatus('Cliente de referencia agregado');
    }
    // quitar usuario que referieren
    public function dropReference(Request $request, User $reference, User $user)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        $reference->hosts()->detach($user->client->id);
        return redirect()->route('references.show', $reference)->withStatus('Cliente de referencia eliminado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $reference)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        return view('hosts.show', ['reference' => $reference, 'hosts' => $reference->hosts()->with('user')->get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $reference)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb']);
        if ($reference->client->active == 0) {
            $reference->client->update(['active' => 1]);
        } else {
            foreach ($reference->hosts as $client) {
                $reference->hosts()->detach($client->id);
            }
            $reference->client->update(['active' => 0]);
        }
        return ($reference->client->active == 1) ? redirect()->route('references.show', $reference) : redirect()->back()->withStatus('Cliente desactivado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
