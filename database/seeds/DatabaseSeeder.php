<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->truncateTables([
            'categoriasProducto',
            'unidadProducto',
            'productos',
            'factura_cabecera',
            'factura_detalle',
            'usuarios'
        ]);

        $this->call(CategoriaProductoSeeder::class);
        $this->call(UnidadProductoSeeder::class);
        $this->call(ProductoSeeder::class);
        $this->call(UsuariosSeeder::class);
    }

    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach($tables as $table)
        {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
