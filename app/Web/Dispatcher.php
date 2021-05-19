<?php

namespace App\Web;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Dispatcher extends Model
{
    protected $fillable = ['user_id', 'station_id', 'schedule_id', 'island_id'];
    // Relacion con la estacion
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
    //Relacion con el turno
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
    // Relacion con la isla y bomba
    public function island()
    {
        return $this->belongsTo(Island::class);
    }
    // Relacion co los usuarios
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
