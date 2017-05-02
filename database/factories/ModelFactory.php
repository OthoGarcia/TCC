<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Produto::class, function (Faker\Generator $faker) {
    static $password;
    $fornecedores = App\Fornecedor::pluck('id')->toArray();
    $categorias = App\Categoria::pluck('id')->toArray();
    return [
        'nome' => $faker->name,
        'descricao' => $faker->text,
        'preco' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10000),
        'estoque_min' => $faker->numberBetween($min = 10, $max = 500),
        'quantidade' => $faker->numberBetween($min = 10, $max = 500),
        'fornecedor_id' => $faker->randomElement($fornecedores),
        'categoria_id' => $faker->randomElement($categorias),
    ];
});

$factory->define(App\Fornecedor::class, function (Faker\Generator $faker) {
    static $password;
    $faker = new Faker\Generator();
    $faker->addProvider(new Faker\Provider\en_US\Person($faker));
   $faker->addProvider(new Faker\Provider\pt_BR\PhoneNumber($faker));
   $faker->addProvider(new Faker\Provider\Lorem($faker));
   $faker->addProvider(new Faker\Provider\Internet($faker));
    return [
        'nome' => $faker->name,
        'descricao' => $faker->text,
        'telefone' => $faker->cellphone,
         'email' => $faker->safeEmail,
    ];
});

$factory->define(App\Categoria::class, function (Faker\Generator $faker) {
    static $password;
    $faker = new Faker\Generator();
   $faker->addProvider(new Faker\Provider\Internet($faker));
   $faker->addProvider(new Faker\Provider\en_US\Person($faker));
   $faker->addProvider(new Faker\Provider\Lorem($faker));
    return [
        'nome' => $faker->name,
        'descricao' => $faker->text,
    ];
});
