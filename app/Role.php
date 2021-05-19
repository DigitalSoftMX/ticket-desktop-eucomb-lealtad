<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Relacion con los usuarios
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    protected $guarded = ['id'];
}
