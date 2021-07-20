<?php

namespace App\Web;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SalesQr extends Model
{
    // Relacion con los clientes
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    // Relacion con las estaciones
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
    // Relacion con el tipo de gasoline
    public function gasoline()
    {
        return $this->belongsTo(Gasoline::class);
    }
    // Relacion con el usuario de invitacion
    public function _reference()
    {
        return $this->belongsTo(User::class, 'reference', 'username');
    }
}
