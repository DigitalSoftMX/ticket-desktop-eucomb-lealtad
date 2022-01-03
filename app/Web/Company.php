<?php

namespace App\Web;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'empresas';
    protected $fillable = ['name', 'address', 'phone', 'image', 'points', 'double_points', 'terms_and_conditions'];
}
