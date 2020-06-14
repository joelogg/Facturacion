<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuarios;
use App\Models\Producto;
use App\Models\UnidadProducto;
use App\Models\CategoriasProducto;

class ApiProductosController extends Controller
{   
    public function create(Request $request)
    {
        $token = $request->input('token');
        $usuario = Usuarios::where('token', $token)->first();
        if($usuario)
        {
            return null;    
        }

        $nombre = $request->input('nombre');
        $categorias_id = $request->input('categorias_id');
        $unidad_id = $request->input('unidad_id');
        $precio = $request->input('precio');
        $margen = $request->input('margen');

        $newData = [
            "nombre"=> $nombre,
            "categorias_id" => $categorias_id,
            "unidad_id" => $unidad_id,
            "precio"=> $precio,
            "margen"=> $margen
        ];

        $producto = Producto::create($newData);
        return $producto->id;
    }

    public function show(Request $request)
    {
        $token = $request->input('token');
        $usuario = Usuarios::where('token', $token)->first();
        if($usuario)
        {
            return null;    
        }

        $productos = Producto::all();
        return $productos;
    }

    public function update(Request $request)
    {   
        $token = $request->input('token');
        $usuario = Usuarios::where('token', $token)->first();
        if($usuario)
        {
            return null;    
        }


        $idP = $request->input('id');
        $producto = Producto::find($idP);
        
        $nombre = $request->input('nombre');
        if($nombre==null || $nombre=="") 
        {
            $nombre = $producto->nombre;
        }

        $precio = $request->input('precio');
        if($precio==null || $precio=="") 
        {
            $precio = $producto->precio;
        }

        $margen = $request->input('margen');
        if($margen==null || $margen=="") 
        {
            $margen = $producto->margen;
        }
        
        $newData = [
            "nombre"=> $nombre,
            "precio"=> $precio,
            "margen"=> $margen
        ];
        $producto->update($newData);

        return $producto;
    }

    public function destroy(Request $request)
    {
        $token = $request->input('token');
        $usuario = Usuarios::where('token', $token)->first();
        if($usuario)
        {
            return null;    
        }


        $idP = $request->input('id');
        /*$producto = Producto::find($idP);
        $rpta = $producto->delete();
        return $rpta;*/

        $res = Producto::destroy($idP);
        if ($res) 
        {   return 1; } 
        else 
        {   return 0; }

        /*return response()->json([
            'status' => '1',
            'msg' => 'success'
        ])*/
    }
}
