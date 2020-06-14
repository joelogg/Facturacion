<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuarios;
use Illuminate\Contracts\Encryption\DecryptException;

class SesionController extends Controller
{
    //----------- Vistas ------------
    public function index()
    {
        return view('login.index',[
            'urlBase' => url('/')
        ]);
    }


    public function login(Request $request)
    {
        $correo = $request->input('correo');
        $contrasenia = $request->input('contrasenia');
        $usuario = Usuarios::where('usuario', $correo)->first();
        
        
        if($usuario)
        {
            $contrasenaDB = decrypt($usuario->contrasena);
            
            if($contrasenia != $contrasenaDB)
            {
                return -1;
            }
            else
            {
                $token = bcrypt($usuario->token."-".$correo);
                $request->session()->put('token', $token);
                $request->session()->put('correo', $correo);
                $request->session()->put('contrasenia', $contrasenia);
                
                $usuario->token = $token;
                $usuario->save();
                return $usuario;
            }
        }
        return null;
    }
}
