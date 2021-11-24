<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
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
