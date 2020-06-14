<?php

use App\Models\CategoriasProducto;
use Illuminate\Database\Seeder;

class CategoriaProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        CategoriasProducto::create([
            'nombre' => 'Frutas',
            'igv' => 0
        ]);

        CategoriasProducto::create([
            'nombre' => 'Verduras',
            'igv' => 0
        ]);

        CategoriasProducto::create([
            'nombre' => 'Abarrotes sin IGV',
            'igv' => 0
        ]);
        
        CategoriasProducto::create([
            'nombre' => 'Abarrotes',
            'igv' => 1
        ]);

        CategoriasProducto::create([
            'nombre' => 'Artículos de limpieza',
            'igv' => 1
        ]);

        CategoriasProducto::create([
            'nombre' => 'Carnes y embutidos',
            'igv' => 1
        ]);

        CategoriasProducto::create([
            'nombre' => 'Aves',
            'igv' => 1
        ]);

        CategoriasProducto::create([
            'nombre' => 'Pescados y mariscos',
            'igv' => 1
        ]);

    }
}
