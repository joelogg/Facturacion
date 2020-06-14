<?php

use App\Models\Usuarios;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuarios::create([
            'nombre' => 'Joel',
            'apellido' => 'Gallegos',
            'img' => '',
            'usuario' => 'joel.o.gallegos.g@gmail.com',
            'contrasena' => Crypt::encrypt('123456a')
        ]);

        Usuarios::create([
            'nombre' => 'Laura',
            'apellido' => 'Estacio',
            'img' => '',
            'usuario' => 'laura.estacio@gmail.com',
            'contrasena' => Crypt::encrypt('123456a')
        ]);
    }
}
