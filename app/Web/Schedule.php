<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    // Accediendo a la base de datos por default del proyecto
    protected $connection = 'mysql';
    protected $fillable = ['name', 'start', 'end', 'station_id'];
}
