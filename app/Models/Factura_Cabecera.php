<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura_Cabecera extends Model
{
    protected $table = 'factura_cabecera';

    protected $fillable = ['nombre', 'monto', 'estado'];

    public function detalles()
    {
        $productos = Factura_Detalle::where('factura_detalle.factura_cabecera_id', $this->id)
            ->leftJoin('productos', 'productos.id', '=', 'factura_detalle.productos_id')
            ->leftJoin('categoriasProducto', 'categoriasProducto.id', '=', 'productos.categorias_id')
            ->leftJoin('unidadProducto', 'unidadProducto.id', '=', 'productos.unidad_id')
            ->select('productos.id as id', 'productos.nombre as nombre', 'factura_detalle.precio AS precio', 
                    'factura_detalle.margen AS margen', 'factura_detalle.cantidad AS cantidad', 
                    'categoriasProducto.id AS categorias_id', 'categoriasProducto.nombre AS nombreCategoria', 'igv', 
                    'unidadProducto.nombre AS unidad', 'abreviacion')
            ->orderby('categoriasProducto.id', 'ASC')
            ->get();
        return $productos;
    }

    public static function crearDetalles($idF, $productos)
    {        
        foreach ($productos as &$producto) 
        {
            $producto['factura_cabecera_id'] = $idF;
        }
        
        $rpta = Factura_Detalle::insert($productos); 
        
        return $rpta;
    }

    public function delete()
    {
        //$this->detalles()->delete();
        //mas rapido, pero mas feo
        Factura_Detalle::where("factura_cabecera_id", $this->id)->delete();
        return parent::delete();
    }

    public function deleteDetalles()
    {
        //$this->detalles()->delete();
        //mas rapido, pero mas feo
        $rpta = Factura_Detalle::where("factura_cabecera_id", $this->id)->delete();
        return $rpta;
    }
}
