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
    return view('welcome');
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
//Colocar os produtos do pedido no estoque
route::get('pedido/estoque/{id}',['as'=>'pedido_estoque_view','uses'=> 'Pedido\\PedidosController@estoque_view']);
route::POST('pedido/estoque/gravar/{id}',['as'=>'pedido_estoque','uses'=> 'Pedido\\PedidosController@estoque']);
