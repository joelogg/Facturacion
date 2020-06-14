<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;

class GuiaRemisionController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->has('token')) 
        {
            return view('login.index',[
                'urlBase' => url('/')
            ]);
        }
        
        $usuario = Usuarios::where('token', $request->session()->get('token'))->first();
        
        return view('guiaRemision.v_guia',[
            'title' => 'Guía de remisión',
            'usuario' => $usuario,
            'idMenu' => 2,
            'idSubMenu' => 1,
            'urlBase' => url('/'),
            'token' => $request->session()->get('token')
        ]);
    }
}
