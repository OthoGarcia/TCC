<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use Session;
use Illuminate\Support\Facades\Auth;
class PDVController extends Controller
{
  public function __construct()
  {
     $this->middleware('auth');
  }

  public function index(){
    return view('pedido.pdv.pdv');
  }

  public function salvar(Request $request){

      $produto = \App\Produto::where('nome','=',$request->input('produto'))
      ->orwhere('id','=',$request->input('produto'))
      ->get();
      //criando um novo pedido ou buscando o ja criado
      if (!$produto->isEmpty()) {
         if ($request->exists('pedido')) {
            $pedido = \App\Pedido::findOrFail($request->input('pedido'));
         }else {
            $pedido = new \App\Pedido;
            $pedido->descricao =
               "Pedido referente ao PDV, funcionario ". Auth::user()->name;
            $pedido->estado = "PDV_Aberto";
            $pedido->save();
         }
         if ($pedido->total == null) {
            $pedido->total = $produto[0]->preco * $request->input('quantidade');
         }else {
            $pedido->total += $produto[0]->preco * $request->input('quantidade');
         }
         //salvando novo produto no pedido ou acresentando quantidade
         if (!$pedido->produtos->contains($produto[0]->id)) {
            $pedido->produtos()->save($produto[0], [
               'quantidade'=>$request->input('quantidade'),
               'preco'=> $produto[0]->preco,
               'sub_total'=>$produto[0]->preco * $request->input('quantidade')
            ]);
         }else{
            $pedido->produtos()->updateExistingPivot($produto[0]->id, [
               'quantidade'=>$request->input('quantidade') +
                  $produto[0]->quantidade,
               'sub_total'=> ($request->input('quantidade') +
                  $produto[0]->quantidade) * $produto[0]->preco,
                  'preco'=> $produto[0]->preco
            ]);
         }
         $produtos = $pedido->produtos;         
         return view('pedido.pdv.pdv',compact('produtos','pedido'));
      }else{
         //error caso n ache o produto (Falta Fazer)
         Session::flash('flash_message', 'Pedido added!');
         return view('pedido.pdv.pdv');
      }
 }
  public function autoComplete($query) {
     $produtos = \App\Produto::where('nome','like','%'.$query.'%')
     ->orwhere('id','like','%'.$query.'%')
     ->get();
      return $produtos->toJson();
   }
}
