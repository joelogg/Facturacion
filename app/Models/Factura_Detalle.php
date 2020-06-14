<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura_Detalle extends Model
{
    protected $table = 'factura_detalle';

    protected $fillable = ['factura_cabecera_id', 'productos_id', 'cantidad', 'precio', 'margen'];

    public function cabecera()
    {
        return $this->belongsTo(Factura_Cabecera::class, 'id');
    }
    
}
