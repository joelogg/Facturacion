<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mavinoo\LaravelBatch\LaravelBatchFacade as Batch;

use App\Models\Usuarios;
use App\Models\Factura_Cabecera;
use App\Models\Factura_Detalle;
use App\Models\Producto;

class ApiFacturaController extends Controller
{
    public function listar(Request $request)
    {
        $token = $request->input('token');
        $usuario = Usuarios::where('token', $token)->first();
        if($usuario)
        {
            return null;    
        }

        $facturas = Factura_Cabecera::all();
        return $facturas;
    }

    public function detalles(Request $request)
    {
        $token = $request->input('token');
        $usuario = Usuarios::where('token', $token)->first();
        if($usuario)
        {
            return null;    
        }

        $idF = $request->input('id');
        $factura = Factura_Cabecera::find($idF);
        if($factura==null)
        {
            return null;
        }
        else
        {
            $data = 
            [
                'productos' => $factura->detalles(),
                'facturaCabecera' => $factura
            ];

            return $data;
        }
    }

    public function crear(Request $request)
    {
        $token = $request->input('token');
        $usuario = Usuarios::where('token', $token)->first();
        if($usuario)
        {
            return null;    
        }

        $nombre = $request->input('nombre');
        $monto = $request->input('monto');
        $estado = $request->input('estado');
        $productos = $request->input('productos');
        $productos = json_decode($productos, true);
        
        //Crear factura cabecera
        $newData = [
            "nombre" => $nombre,
            "monto"  => $monto,
            "estado" => $estado
        ];
        $facturaCab = Factura_Cabecera::create($newData);
        
        //Creando detalles cabecera
        $rpta = Factura_Cabecera::crearDetalles($facturaCab->id, $productos);

        //Actualizando los datos de productosTabla
        $productosUpdate = array();
        foreach ($productos as $producto) 
        {
            array_push($productosUpdate, 
            [
                "id" => $producto['productos_id'],
                "precio" => $producto['precio'],
                "margen" => $producto['margen']
            ]);
        }
        
        $productoInstance = new Producto;
        $rpta = Batch::update($productoInstance, $productosUpdate, 'id');
        
        return $facturaCab->id;
    }

    public function eliminar(Request $request)
    {
        $token = $request->input('token');
        $usuario = Usuarios::where('token', $token)->first();
        if($usuario)
        {
            return null;    
        }

        $idF = $request->input('id');
        $factura = Factura_Cabecera::find($idF);

        if($factura==null)
        {
            return "0";
        }

        $rpta = $factura->delete();

        return (string)$rpta;
    }

    public function editar(Request $request)
    {
        $token = $request->input('token');
        $usuario = Usuarios::where('token', $token)->first();
        if($usuario)
        {
            return null;    
        }
        
        $idF = $request->input('id');
        $nombre = $request->input('nombre');
        $monto = $request->input('monto');
        $estado = $request->input('estado');
        $productos = $request->input('productos');
        $productos = json_decode($productos, true);
        
        
        $factura = Factura_Cabecera::find($idF);

        if($factura==null)
        {
            return "0";
        }
        
        //Eliminando detalles
        $rpta = $factura->deleteDetalles();

        //Creado detalles
        $rpta = Factura_Cabecera::crearDetalles($factura->id, $productos);
        if($rpta=="0") {return "0";}

        //Actualizando los datos de productosTabla
        $productosUpdate = array();
        foreach ($productos as $producto) 
        {
            array_push($productosUpdate, 
            [
                "id" => $producto['productos_id'],
                "precio" => $producto['precio'],
                "margen" => $producto['margen']
            ]);
        }
        
        $productoInstance = new Producto;
        $rpta = Batch::update($productoInstance, $productosUpdate, 'id');

        //Actualizando cabecera
        $factura->nombre = $nombre;
        $factura->monto = $monto;
        $factura->estado = $estado;
        $rpta = $factura->save();

        return (string)$rpta;
    }
}
