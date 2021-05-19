<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class Island extends Model
{
    // Accediendo a la base de datos por default del proyecto
    protected $connection = 'mysql';
    protected $fillable = ['station_id', 'island', 'bomb'];
    // Relacion con la estacion
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
