<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriasProducto extends Model
{
    protected $table = 'categoriasProducto';
    //public $timestamps = false;

    protected $fillable = ['nombre'];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categorias_id');
    }
}
