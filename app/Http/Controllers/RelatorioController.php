<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Produto as Produto;
use DB;

class RelatorioController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth');
   }
   public function index(Request $request)
   {
      $keyword = $request->get('search');
      $fornecedor = $request->get('fornecedor');
      $categoria = $request->get('categoria');      

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
      if (!empty($fornecedor)) {
         $fornecedor_selecionado = $fornecedor;
      }else{
         $fornecedor_selecionado = null;
      }
      if (!empty($categoria)) {
         $categoria_selecionada = $categoria;
      }else{
         $categoria_selecionada = null;
      }


      $escolhas = array('e','ou');
      $escolha = $request->input('escolha');
      //igual a 1 == 'ou'
      if($escolha == 1){
         $produtos = DB::table('produtos')
         ->when($keyword, function($query) use ($keyword){
            return $query->where('nome', 'LIKE', "%$keyword%");
         })
         ->when($keyword, function($query) use ($keyword){
            return $query->orWhere('descricao', 'LIKE', "%$keyword%");
         })
         ->when($fornecedor, function($query) use($fornecedor){
            return $query->whereIn('fornecedor_id',$fornecedor);
         })
         ->when($categoria, function($query) use($categoria){
            return $query->orWhereIn('categoria_id',$categoria);
         })
             ->paginate($perPage);
      }else{
         $produtos = DB::table('produtos')
         ->when($keyword, function($query) use ($keyword){
            return $query->where('nome', 'LIKE', "%$keyword%");
         })
         ->when($keyword, function($query) use ($keyword){
            return $query->orWhere('descricao', 'LIKE', "%$keyword%");
         })
         ->when($fornecedor, function($query) use($fornecedor){
            return $query->whereIn('fornecedor_id',$fornecedor);
         })
         ->when($categoria, function($query) use($categoria){
            return $query->whereIn('categoria_id',$categoria);
         })
             ->paginate($perPage);
      }
      return view('relatorios.produtos', compact('produtos','fornecedores','categorias',
         'categoria_selecionada','fornecedor_selecionado','escolha','escolhas'));
   }
}
