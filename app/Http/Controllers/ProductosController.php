<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Producto;
use App\Models\UnidadProducto;
use App\Models\CategoriasProducto;
use App\Models\Usuarios;

class ProductosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('token')) 
        {
            return view('login.index',[
                'urlBase' => url('/')
            ]);
        }

        
        $unidades = UnidadProducto::all();
        $categorias = CategoriasProducto::all();

        $productos = array();
        foreach($categorias as $categoria)
        {
            $productosCategoria = Producto::where('categorias_id', $categoria->id)
                ->leftJoin('unidadProducto', 'unidadProducto.id', '=', 'productos.unidad_id')
                ->select('productos.id AS id', 'productos.nombre as nombre', 'precio', 'margen', 'unidadProducto.nombre AS unidad')->get();
            $productosCategoria = ['id' => $categoria->id, 'categoria' => $categoria->nombre, 'productos' =>$productosCategoria];
            array_push($productos, $productosCategoria);
        }
       
        $usuario = Usuarios::where('token', $request->session()->get('token'))->first();
        
        return view('productos.v_productos',[
            'title' => 'Productos',
            'unidades' => $unidades,
            'categorias' => $categorias,
            'productos' => $productos,
            'usuario' => $usuario,
            'idMenu' => 3,
            'idSubMenu' => 1,
            'urlBase' => url('/'),
            'token' => $request->session()->get('token')
        ]);
    }

}
