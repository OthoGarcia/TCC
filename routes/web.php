<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

   Route::resource('permission/permissions', 'Permission\\PermissionsController');
   Route::resource('role/roles', 'Role\\RolesController');


Route::resource('categoria/categorias', 'categoria\\CategoriasController');
Route::resource('produto/produtos', 'produto\\ProdutosController');
Route::resource('fornecedor/fornecedor', 'Fornecedor\\FornecedorController');
Route::resource('pedido/pedidos', 'Pedido\\PedidosController');
Route::resource('pedido_produto/pedido_produto', 'Pedido_Produto\\pedido_produtoController');

//pedido
route::get('pedido_produto/{id}',['as'=>'add_pedido_produto','uses'=> 'Pedido_Produto\\pedido_produtoController@create']);
route::post('pedido_produto/store/{id}','Pedido_Produto\\pedido_produtoController@store');
route::post('pedido_produto/update/{id}','Pedido_Produto\\pedido_produtoController@update');
route::get('/pedido/duplicidade/{id}/{acao}',['as'=>'duplicidade_pedido_produto','uses'=> 'Pedido_Produto\\pedido_produtoController@duplicidade']);
//lista de compras
route::get('pedido/lista',['as'=>'pedido_lista','uses'=> 'Pedido\\PedidosController@index_lista']);
//GERAR PEDIDOS
route::get('pedido/gerar/{id}',['as'=>'gerar_pedido','uses'=> 'Pedido\\PedidosController@gerar_pedido']);
//EFETUAR PEDIDO
route::get('pedido/efetuar/{id}',['as'=>'efetuar_pedido','uses'=> 'Pedido\\PedidosController@efetuar_pedido']);
//exibir pedido PDF
route::get('pedido/visualizar/{id}',['as'=>'visualizar_pedido','uses'=> 'Pedido\\PedidosController@visualizar_pedido']);
//PEDIDO ENTREGUE
route::get('pedido/entregue/{id}',['as'=>'pedido_entregue','uses'=> 'Pedido\\PedidosController@entregue']);
//Colocar os produtos do pedido no estoque e colocar pagamento
route::get('pedido/estoque/{id}',['as'=>'pedido_estoque_view','uses'=> 'Pedido\\PedidosController@estoque_view']);
route::POST('pedido/estoque/gravar/{id}',['as'=>'pedido_estoque','uses'=> 'Pedido\\PedidosController@estoque']);
route::Post('pedido/pagamento',['as'=>'pedido_pagamento','uses'=> 'Pedido\\PedidosController@pagamento_compra']);
//pagamento pedido de compra
route::get('pedido/pagamento/{id}',['as'=>'pedido_pagamento_view','uses'=> 'Pedido\\PedidosController@pagamento_view']);
route::Post('pedido/pagamento/parcela/{id}',['as'=>'pedido_pagamento_parcela','uses'=> 'Pedido\\PedidosController@pagamento_parcela']);
//PDV
route::get('pdv',['as'=>'pdv','uses'=> 'PDVController@index']);
route::get('pdv/{id}',['as'=>'pdv_produtos','uses'=> 'PDVController@index_produtos']);
route::get('autocomplete/{query}',['as'=>'autocomplete','uses'=> 'PDVController@autoComplete']);
route::get('peso/{id}',['as'=>'peso','uses'=> 'PDVController@peso']);
route::get('finalizar/{id}/{forma}',['as'=>'finalizar','uses'=> 'PDVController@finalizar']);
route::get('deletar/{id}',['as'=>'deletar','uses'=> 'PDVController@deletar']);
route::post('pdv/salvar',['as'=>'pdv_salvar','uses'=> 'PDVController@salvar']);

//relatorios
route::get('relatorio/produto',['as'=>'relatorio_produto','uses'=> 'RelatorioController@index']);

Route::resource('ingrediente/ingredientes', 'Ingrediente\\IngredientesController');
route::post('ingrediente/ingredientes/adicionar',['as'=>'ingrediente_create_adicionar','uses'=> 'Ingrediente\\IngredientesController@adicionar']);
route::get('ingrediente/criar/adicionar/{idIngrediante}',['as'=>'ingrediente_adicionar_criar','uses'=> 'Ingrediente\\IngredientesController@createAdicionar']);
route::get('ingrediente/materiaPrima/{idIngrediante}',['as'=>'ingrediente_materiaPrima_criar','uses'=> 'Ingrediente\\IngredientesController@createMateriaPrima']);
route::post('ingrediente/adicionar',['as'=>'ingrediente_adicionar','uses'=> 'Ingrediente\\IngredientesController@adicionar']);
route::post('ingrediente/item/deletar/{id}/{idProduto}',['as'=>'ingrediente_deletar_item','uses'=> 'Ingrediente\\IngredientesController@deletarItem']);

//tela inicial
route::get('home/listaEstoque',['as'=>'home_listaEstoque','uses'=> 'HomeController@listaEstoque']);
