<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = ['client_id', 'balance', 'image_payment', 'station_id', 'status', 'deny'];
    // Conexion con el usuario cliente
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    // Relacion con las estaciones
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
