<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['name', 'points', 'value', 'id_status', 'id_station'];
    // Relacion con las estaciones
    public function station()
    {
        return $this->belongsTo(Station::class, 'id_station', 'id');
    }
    // Relacion con los status del vale
    public function status()
    {
        return $this->belongsTo(CatStatus::class, 'id_status', 'id');
    }
}
