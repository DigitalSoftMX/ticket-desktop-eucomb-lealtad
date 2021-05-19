<?php

namespace App\Web;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $fillable = ['status', 'admin_id', 'created_at'];
    // Relacion con los clientes
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    // Relacion conlas estaciones
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
    // Relacion con el estado del canje
    public function estado()
    {
        return $this->belongsTo(Status::class, 'status', 'id');
    }
    // Relacion con el administrador
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}
