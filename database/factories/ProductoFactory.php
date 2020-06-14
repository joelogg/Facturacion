<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Producto;
use Faker\Generator as Faker;

$factory->define(Producto::class, function (Faker $faker) {
    return [
        'nombre' => $faker->name,
        'precio' => $faker->randomFloat(2, 0, 200),
        'margen' => $faker->numberBetween(20, 24),
        'categorias_id' => $faker->numberBetween(1, 7),
        'unidad_id' => $faker->numberBetween(1, 25)
    ];
});
