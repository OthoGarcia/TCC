<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Produto as Produto;

class RelatorioController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth');
   }
   public function index(Request $request)
   {
      $keyword = $request->get('search');
      $perPage = 25;
      //selecionando categorias
      $cats = \App\Categoria::orderBy('nome')->get();;
      $categorias = array();
      $categorias[0] = 'Nenhuma';
      foreach ($cats as $cat) {
         $categorias[$cat->id] = $cat->nome;
      }
      //selecionando fornecedores
      $forns = \App\Fornecedor::orderBy('nome')->get();
      $fornecedores = array();
      $fornecedores[0] = 'Nenhuma';
      foreach ($forns as $forn) {
         $fornecedores[$forn->id] = $forn->nome;
      }
      if (!empty($request->input('fornecedor'))) {
         $fornecedor_selecionado = $request->input('fornecedor');
      }
      if (!empty($request->input('categoria'))) {
         $categoria_selecionada = $request->input('categoria');
      }      

      //escolhas 'and' ou 'or' para a estrutura do sql
      $escolha = array('e','ou');
      if (!empty($keyword) or !empty($request->input('fornecedor')) or !empty($request->input('categoria'))) {
         //escolha == 1 == 'ou' or
         if($request->input('escolha') == 1){
            $produtos = Produto::whereIn('fornecedor_id',$request->input('fornecedor'))
            ->orWhereIn('categoria_id', $request->input('categoria'))
            ->where('nome', 'LIKE', "%$keyword%")
            ->where('descricao', 'LIKE', "%$keyword%")
            ->where('preco', 'LIKE', "%$keyword%")
            ->where('estoque_min', 'LIKE', "%$keyword%")
                ->paginate($perPage);
         }else{
            $produtos = Produto::whereIn('fornecedor_id',$request->input('fornecedor'))
            ->whereIn('categoria_id', $request->input('categoria'))
            ->where('nome', 'LIKE', "%$keyword%")
            ->where('descricao', 'LIKE', "%$keyword%")
            ->where('preco', 'LIKE', "%$keyword%")
            ->where('estoque_min', 'LIKE', "%$keyword%")
                ->paginate($perPage);
         }
      } else {
           $produtos = Produto::paginate($perPage);
      }

      return view('relatorios.produtos', compact('produtos','fornecedores','categorias',
         'categoria_selecionada','fornecedor_selecionado','escolha'));
   }
}
