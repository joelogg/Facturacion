<?php

use App\Models\UnidadProducto;
use Illuminate\Database\Seeder;

class UnidadProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadProducto::create([
            'nombre' => 'MAZO',
            'abreviacion' => 'MAZO'
        ]);

        UnidadProducto::create([
            'nombre' => 'CAJA',
            'abreviacion' => 'CJA'
        ]);

        UnidadProducto::create([
            'nombre' => 'KILOGRAMO',
            'abreviacion' => 'KG'
        ]);

        UnidadProducto::create([
            'nombre' => 'GRAMO',
            'abreviacion' => 'GR'
        ]);

        UnidadProducto::create([
            'nombre' => 'SACO',
            'abreviacion' => 'SACO'
        ]);

        //
        UnidadProducto::create([
            'nombre' => 'LITRO',
            'abreviacion' => 'LT'
        ]);
        UnidadProducto::create([
            'nombre' => 'MILILITRO',
            'abreviacion' => 'ML'
        ]);

        UnidadProducto::create([
            'nombre' => 'SOBRE',
            'abreviacion' => 'SB'
        ]);

        UnidadProducto::create([
            'nombre' => 'FRASCO',
            'abreviacion' => 'FR'
        ]);

        UnidadProducto::create([
            'nombre' => 'UNIDAD',
            'abreviacion' => 'UND'
        ]);

        //
        UnidadProducto::create([
            'nombre' => 'PAQUETE',
            'abreviacion' => 'PQT'
        ]);
        UnidadProducto::create([
            'nombre' => 'BOLSA',
            'abreviacion' => 'BOLSA'
        ]);

        UnidadProducto::create([
            'nombre' => 'GALON',
            'abreviacion' => 'GL'
        ]);

        UnidadProducto::create([
            'nombre' => 'CIENTO',
            'abreviacion' => 'CIENTO'
        ]);

        UnidadProducto::create([
            'nombre' => 'BALDE',
            'abreviacion' => 'BALDE'
        ]);
        
        //
        UnidadProducto::create([
            'nombre' => 'BIDON',
            'abreviacion' => 'BIDON'
        ]);
        UnidadProducto::create([
            'nombre' => 'DOCENA',
            'abreviacion' => 'DOCENA'
        ]);

        UnidadProducto::create([
            'nombre' => 'SIX PACK',
            'abreviacion' => 'SIX PACK'
        ]);

        UnidadProducto::create([
            'nombre' => 'LATA',
            'abreviacion' => 'LATA'
        ]);

        UnidadProducto::create([
            'nombre' => 'SACHET',
            'abreviacion' => 'SACHET'
        ]);
        
        //
        UnidadProducto::create([
            'nombre' => 'BOTELLA',
            'abreviacion' => 'BOTELLA'
        ]);
        UnidadProducto::create([
            'nombre' => 'PAR',
            'abreviacion' => 'PAR'
        ]);

        UnidadProducto::create([
            'nombre' => 'ROLLO',
            'abreviacion' => 'ROLLO'
        ]);

        UnidadProducto::create([
            'nombre' => 'SET',
            'abreviacion' => 'SET'
        ]);

        UnidadProducto::create([
            'nombre' => 'PIEZA',
            'abreviacion' => 'PIEZA'
        ]);

        //26
        UnidadProducto::create([
            'nombre' => 'CABEZA',
            'abreviacion' => 'CABEZA'
        ]);
        UnidadProducto::create([
            'nombre' => 'MOLDE',
            'abreviacion' => 'MOLDE'
        ]);
        UnidadProducto::create([
            'nombre' => 'COJINE',
            'abreviacion' => 'COJINE'
        ]);
        UnidadProducto::create([
            'nombre' => 'SERVICIO',
            'abreviacion' => 'SERVICIO'
        ]);
        UnidadProducto::create([
            'nombre' => 'POTE',
            'abreviacion' => 'POTE'
        ]);

        //31
        UnidadProducto::create([
            'nombre' => 'PLANCHA',
            'abreviacion' => 'PLANCHA'
        ]);
    }
}

