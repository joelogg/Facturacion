<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = ['categorias_id', 'unidad_id', 'nombre', 'precio', 'margen'];
}
