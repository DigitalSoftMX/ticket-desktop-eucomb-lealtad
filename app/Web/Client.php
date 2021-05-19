<?php

namespace App\Web;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['active'];
    // Relacion con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relacion con los pagos del cliente
    public function deposits()
    {
        return $this->hasMany(UserHistoryDeposit::class);
    }
    // Relacion con los pagos del cliente
    public function shareds()
    {
        return $this->hasMany(SharedBalance::class, 'transmitter_id');
    }

    // Relacion con los pagos del cliente
    public function receivers()
    {
        return $this->hasMany(SharedBalance::class, 'receiver_id');
    }
    // Relacion con los pagos del cliente
    public function payments()
    {
        return $this->hasMany(DispatcherHistoryPayment::class);
    }
    // Relacion con los canjes
    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }
    // Relacion con los puntos escaneados
    public function qrs()
    {
        return $this->hasMany(SalesQr::class);
    }
    // Relacion con los usuarioa a referencia
    public function main()
    {
        return $this->belongsToMany(User::class, 'user_client');
    }
}
