<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table = 'station';

    protected $fillable = ['name', 'address', 'phone', 'email', 'id_empresa', 'id_type', 'number_station', 'active', 'lealtad', 'image', 'abrev'];
    // Conexion con las ventas
    public function sales()
    {
        return $this->hasMany(DispatcherHistoryPayment::class);
    }
    // Realacion con los depositos de los clientes
    public function deposits()
    {
        return $this->hasMany(UserHistoryDeposit::class);
    }
    // Relacion con los despachadores
    public function dispatchers()
    {
        return $this->hasMany(Dispatcher::class);
    }
    // relacion con los horarios
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    // Relacion con las islas y bombas
    public function islands()
    {
        return $this->hasMany(Island::class);
    }
    // Relacion con los rangos de vales
    public function ranges()
    {
        return $this->hasMany(CountVoucher::class, 'id_station', 'id');
    }
    // Relacion con los vales
    function vouchers()
    {
        return $this->hasMany(Voucher::class, 'id_station', 'id');
    }
    // Relacion con los canjes solicitados
    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }
}
