<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class CountVoucher extends Model
{
    protected $table = 'count_vouchers';
    protected $fillable = ['id_station', 'min', 'max', 'status', 'remaining'];
    // Relacion con la estacion
    public function station()
    {
        return $this->belongsTo(Station::class, 'id_station', 'id');
    }
    // Relacion con el status
    public function estado()
    {
        return $this->belongsTo(Status::class, 'status', 'id');
    }
}
