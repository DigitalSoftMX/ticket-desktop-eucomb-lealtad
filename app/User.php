<?php

namespace App;

use App\Web\AdminStation;
use App\Web\Client;
use App\Web\Dispatcher;
use App\Web\Exchange;
use App\Web\SalesQr;
use App\Web\UserHistoryDeposit;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use Notifiable;
    // Relacion a muchos para el rol del usuario
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    // Relacion usuario cliente
    public function client()
    {
        return $this->hasOne(Client::class);
    }
    // Relacion usuario despachador
    public function dispatcher()
    {
        return $this->hasOne(Dispatcher::class, 'user_id', 'id');
    }
    // Relacion con las estaciones si es admin
    public function admin()
    {
        return $this->hasOne(AdminStation::class);
    }
    // Relacion con los benefactores
    public function hosts()
    {
        return $this->belongsToMany(Client::class, 'user_client');
    }
    // Relación con los qr's por beneficio
    public function qrs()
    {
        return $this->hasMany(SalesQr::class, 'main_id', 'id');
    }
    public function deposits()
    {
        return $this->hasMany(UserHistoryDeposit::class, 'reference', 'username');
    }
    // Relacion con los clientes para el caso de administrador ventas
    public function references()
    {
        return $this->belongsToMany(Client::class, 'sale_clients', 'sale_id');
    }
    // Relacion con las ventas por QR para el caso administrador ventas
    public function salesqrs()
    {
        return $this->hasMany(SalesQr::class, 'reference', 'username');
    }
    // Relacion con los canjes para el caso de administrador ventas
    public function exchanges()
    {
        return $this->hasMany(Exchange::class, 'reference', 'username');
    }
    // funcion que pregunta si el rol esta autorizado
    public function authorizeRoles($roles)
    {
        if ($this->hasAnyRole($roles)) {
            return true;
        }
        abort(401, 'This action is unauthorized');
    }

    private function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    private function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
    // Método para el admin estacion
    public function station($user, $station)
    {
        if ($user->roles[0]->id == 3) {
            return $user->admin->station;
        }
        return $station;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'first_surname', 'second_surname', 'email', 'sex', 'phone', 'password', 'active', 'address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
