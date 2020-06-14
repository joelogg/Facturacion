<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\UnidadProducto;
use App\Models\CategoriasProducto;
use App\Models\Factura_Cabecera;
use App\Models\Usuarios;

class FacturaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('token')) 
        {
            return view('login.index',[
                'urlBase' => url('/')
            ]);
        }


        $productos = Producto::leftJoin('unidadProducto', 'unidadProducto.id', '=', 'productos.unidad_id')
                ->select('productos.id AS id', 'productos.nombre as nombre', 'precio', 'margen', 'categorias_id', 'unidadProducto.nombre AS unidad', 'abreviacion')->get();
        
        $categorias = CategoriasProducto::all();
        $usuario = Usuarios::where('token', $request->session()->get('token'))->first();


        $facturaDetalles = [];
        $facturaId = -1;
        $facturaNombre = "";
        
        $idF = $request->input('idFactura');
        $factura = Factura_Cabecera::find($idF);
        if($factura!=null)
        {
            $facturaId = $idF;
            $facturaNombre = $factura->nombre;
            $facturaDetalles = $factura->detalles();
        }
        
       

        return view('factura.v_crearFactura',[
            'productos' => $productos,
            'categorias' => $categorias,
            'title' => 'Crear factura',
            'usuario' => $usuario,
            'facturaDetalles' => $facturaDetalles,
            'facturaId' => $facturaId,
            'facturaNombre' => $facturaNombre,
            'idMenu' => 1,
            'idSubMenu' => 1,
            'urlBase' => url('/'),
            'valorIGV' => 1.18,
            'token' => $request->session()->get('token')
        ]);
    }

    public function listaFinalizadas(Request $request)
    {
        if (!$request->session()->has('token')) 
        {
            return view('login.index',[
                'urlBase' => url('/')
            ]);
        }

        $facturas = Factura_Cabecera::where('estado', '1')->get();
        $usuario = Usuarios::where('token', $request->session()->get('token'))->first();
        
        return view('factura.v_listaFacturas',[
            'facturas' => $facturas,
            'title' => 'Lista de facturas finalizadas',
            'usuario' => $usuario,
            'valorIGV' => 1.18,
            'idMenu' => 1,
            'idSubMenu' => 2,
            'urlBase' => url('/'),
            'token' => $request->session()->get('token')
        ]);
    }

    public function listaAvances(Request $request)
    {
        if (!$request->session()->has('token')) 
        {
            return view('login.index',[
                'urlBase' => url('/')
            ]);
        }

        $facturas = Factura_Cabecera::where('estado', '0')->get();
        $usuario = Usuarios::where('token', $request->session()->get('token'))->first();
        
        return view('factura.v_listaFacturas',[
            'facturas' => $facturas,
            'title' => 'Lista de facturas en avance',
            'usuario' => $usuario,
            'valorIGV' => 1.18,
            'idMenu' => 1,
            'idSubMenu' => 3,
            'urlBase' => url('/'),
            'token' => $request->session()->get('token')
        ]);
    }

}
