<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class DispatcherHistoryPayment extends Model
{
    // Accediendo a la base de datos por default del proyecto
    protected $connection = 'mysql';
    /* Accediendo a la tabla ventas */
    protected $table = 'sales';
    // Enlace con el tipo de gasolina
    public function gasoline()
    {
        return $this->belongsTo(Gasoline::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    // Relacion con los depachadores
    public function dispatcher()
    {
        return $this->belongsTo(Dispatcher::class);
    }
}
