<?php

use Illuminate\Database\Seeder;

class ProdutosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(App\Categoria::class, 50)->create()->each(function ($u) {         
      });
      factory(App\Fornecedor::class, 50)->create()->each(function ($u) {
      });
      factory(App\Produto::class, 50)->create()->each(function ($u) {
      });
    }
}
