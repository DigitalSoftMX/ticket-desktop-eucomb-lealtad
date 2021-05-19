<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = ['nombre', 'direccion', 'telefono', 'imglogo', 'points', 'double_points'];
}
