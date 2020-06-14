<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadProducto extends Model
{
    protected $table = 'unidadProducto';
    //public $timestamps = false;

    protected $fillable = ['nombre'];
}
