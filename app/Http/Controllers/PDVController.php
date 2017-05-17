<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PDVController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth');
   }

   public function index(){
      $pedido = \App\Pedido::where('estado','=','PDV_Aberto')->first();
      if (!$pedido) {
         return view('pedido.pdv.pdv');
      }else {
         //dd($pedido);
         $produtos = $pedido->produtos;
         return view('pedido.pdv.pdv',compact('produtos','pedido'));
      }

   }
   public function index_produtos($id){
      $pedido = \App\Pedido::findOrFail($request->input('pedido'));
      $produtos = $pedido->produtos;
      return view('pedido.pdv.pdv',compact('produtos','pedido'));
      return view('pedido.pdv.pdv');
   }


   public function salvar(Request $request){
      $produto = \App\Produto::where('nome','=',$request->input('produto'))
      ->orwhere('id','=',$request->input('produto'))
      ->first();
      //criando um novo pedido ou buscando o ja criado
      if ($produto) {
         if ($produto->peso != null) {
            $this->validate($request, [
               'peso' => 'required',
            ]);
         }
         if (\App\Pedido::where('estado','=','PDV_Aberto')->first()) {
            $pedido = \App\Pedido::where('estado','=','PDV_Aberto')->first();            
         }else {
            $pedido = new \App\Pedido;
            $pedido->descricao =
            "Pedido referente ao PDV, funcionario ". Auth::user()->name;
            $pedido->estado = "PDV_Aberto";
            $pedido->user()->associate(Auth::user());
            $pedido->save();
         }
         if ($pedido->total == null) {
            $pedido->total = $produto->preco * $request->input('quantidade');
         }else {
            $pedido->total += $produto->preco * $request->input('quantidade');
         }
         $pedido->save();
         //verificando se o produto é vendido por peso
         if ($produto->peso == null) {
            $peso = null;
         }else{
            $peso = $request->input('peso');
         }
         //salvando novo produto no pedido ou acresentando quantidade
         if (!$pedido->produtos->contains($produto->id)) {
            $pedido->produtos()->save($produto, [
               'quantidade'=>$request->input('quantidade'),
               'preco'=> $produto->preco,
               'sub_total'=>$produto->preco * $request->input('quantidade'),
               'peso'=>$peso
            ]);
         }else{
            //dd($produto);
            $produto = $pedido->produtos()->where('produto_id',$produto->id)->first();
            $pedido->produtos()->updateExistingPivot($produto->id, [
               'quantidade'=>$request->input('quantidade') +
               $produto->pivot->quantidade,
               'sub_total'=> ($request->input('quantidade') +
               $produto->pivot->quantidade) * $produto->preco,
               'preco'=> $produto->preco,
               'peso'=>$peso + $produto->pivot->peso
            ]);
         }
      }else{
         //error caso n ache o produto (Falta Fazer)
         Session::flash('flash_message', 'Pedido added!');
      }
      return redirect()->action('PDVController@index');
   }
   public function finalizar($id, $forma){
      $pedido = \App\Pedido::findOrFail($id);
      $produtos = $pedido->produtos;
      foreach ($produtos as $produto) {
         if ($produto->peso == null) {
            $produto->quantidade = $produto->quantidade - $produto->pivot->quantidade;
         }else{
            $produto->peso_quantidade = $produto->peso_quantidade - $produto->pivot->peso;
            $produto->quantidade = round($produto->peso_quantidade/$produto->peso);
         }
         $produto->save();
      }
      $pedido->estado = 'PDV_Finalizado';
      $pedido->save();
      $pagamento = new \App\Pagamento;
      $pagamento->tipo = "Entrada";
      $pagamento->descricao = "Pagamendo efetuado no PDV";
      $pagamento->valor = $pedido->total;
      $pagamento->data = Carbon::now();
      if ($forma == 0 ) {
         $pagamento->forma = "Dinheiro";
      }else {
         $pagamento->forma = "Cartão";
      }
      $pagamento->save();
      $pedido->pagamento()->associate($pagamento);
      $pedido->save();
      return redirect()->action('PDVController@index');
   }
   public function deletar($id)
   {
      $produto = \App\Pedido::findOrFail($id)->produtos()
      ->orderBy('pedido_produto.updated_at','desc')
      ->first();
      $pedido= \App\Pedido::findOrFail($id);
      $pedido->total -= $produto->pivot->quantidade * $produto->pivot->preco;
      $pedido->produtos()->detach($produto->id);
      $pedido->save();
      return redirect()->action('PDVController@index');
   }
   public function autoComplete($query) {
      $produtos = \App\Produto::where('nome','like','%'.$query.'%')
      ->orwhere('id','like','%'.$query.'%')
      ->get();
      return $produtos->toJson();
   }
   public function peso($id)
   {
      $produto = \App\Produto::findOrFail($id);
      return $produto->toJson();
   }

}
