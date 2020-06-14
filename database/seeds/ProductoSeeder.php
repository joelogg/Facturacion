<?php

use App\Models\Producto;
use App\Models\CategoriasProducto;
use App\Models\UnidadProducto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_handle = fopen(public_path().'/documentos/productos.csv', 'r');
        $productos = array();
        while (!feof($file_handle)) 
        {
            $line = fgetcsv($file_handle, 0, ';');

            $precio = $line[3];
            if($precio=="") { $precio = 1000;}

            $margen = $line[4];
            if($margen=="") { $margen = 1000;}



            array_push($productos, [
                'categorias_id' => $line[0],
                'nombre' => $line[1],
                'unidad_id' => $line[2],
                'precio' => $precio,
                'margen' => $margen
            ]);
        }
        fclose($file_handle);

        $rpta = Producto::insert($productos);
    }
}
