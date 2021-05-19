<?php

namespace App\Http\Controllers;

use App\Eucomb\User as EucombUser;
use App\User;
use App\Role;
use App\Http\Requests\UserRequest;
use App\Web\AdminStation;
use App\Web\Dispatcher;
use App\Web\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(Request $request, User $model)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        return view('users.index', ['users' => $model->paginate(15)]);
    }
    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        return view('users.create', ['roles' => Role::all(), 'stations' => Station::all()]);
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        $eucomb = null;
        foreach ($request->rol as $rol) {
            if ($role = ($rol == 3 || $rol == 4)) {
                request()->validate(['station' => 'required']);
            }
            if ($rol == 2) {
                $eucomb = $rol;
            }
        }
        $user = User::create($request->merge(['password' => Hash::make($request->get('password'))])->all());
        if ($role != null || $eucomb == 2) {
            if ($request->rol[count($request->rol) - 1] == 4) {
                $dispatcher = new Dispatcher();
                while (true) {
                    $dispatcher_id = rand(10000000, 99999999);
                    $dispatcher->dispatcher_id = 'GD-' . $dispatcher_id;
                    if (!(Dispatcher::where('dispatcher_id', $dispatcher->dispatcher_id)->exists())) {
                        break;
                    }
                }
                $dispatcher->user_id = $user->id;
                $dispatcher->station_id = $request->station;
                $dispatcher->save();
                $user->roles()->attach(Role::where('name', 'despachador')->first());
                return redirect()->route('user.index')->withStatus(__('Despachador creado con éxito'));
            }
            if ($request->station != null) {
                $request->merge(['user_id' => $user->id, 'station_id' => $request->station]);
                AdminStation::create($request->only(['user_id', 'station_id']));
            }
        }
        $user->roles()->attach($request->rol);
        return redirect()->route('user.index')->withStatus(__('Administrador creado con éxito'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user, Request $request, Role $roles)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);
        //$estacion = Estacion::all();
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User  $user)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);

        $hasPassword = $request->get('password');
        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except([$hasPassword ? '' : 'password'])
        );

        $user->roles()->updateExistingPivot($request->rol_actual, ['role_id' => $request->rol]);

        return redirect()->route('user.index')->withStatus(__('Usuario actualizado con éxito.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user, Request $request)
    {
        $request->user()->authorizeRoles(['admin_master', 'admin_eucomb', 'admin_estacion']);

        $user->delete();

        return redirect()->route('user.index')->withStatus(__('Usuario eliminado exitosamente.'));
    }
}
