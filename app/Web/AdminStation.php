<?php

namespace App\Web;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AdminStation extends Model
{
    protected $fillable = ['user_id', 'station_id'];
    // Relacion con los usuarios
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relacion con las estaciones
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
    // Relacion con los turnos
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
