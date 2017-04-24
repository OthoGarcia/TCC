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

route::get('pedido_produto/{id}',['as'=>'add_pedido_produto','uses'=> 'Pedido_Produto\\pedido_produtoController@create']);
route::post('pedido_produto/store/{id}','Pedido_Produto\\pedido_produtoController@store');
route::post('pedido_produto/update/{id}','Pedido_Produto\\pedido_produtoController@update');
