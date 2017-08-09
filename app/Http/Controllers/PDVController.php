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
      $data = Carbon::now()->format('d/m/Y');
      if (!$pedido) {
         return view('pedido.pdv.pdv',compact('data'));
      }else {
         //dd($pedido);
         $produtos = $pedido->produtos;
         $sub_total = $pedido->total;
         return view('pedido.pdv.pdv',compact('produtos','pedido','data','sub_total'));
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
      ->orwhere('cod_barras','=',$request->input('produto'))
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
            if ($produto->peso == null) {
               $pedido->total = $produto->preco * $request->input('quantidade');
            }else{
               $pedido->total = $produto->preco * ($request->input('peso')/1000);
            }
         }else {
            if ($produto->peso == null) {
               $pedido->total += $produto->preco * $request->input('quantidade');
            }else {
               $pedido->total += $produto->preco * ($request->input('peso')/1000);
            }
         }
         $pedido->save();
         //verificando se o produto é vendido por peso
         if ($produto->peso == null) {
            $peso = null;
            $quantidade = $request->input('quantidade');

         }else{
            $quantidade = null;
            $peso = $request->input('peso');
         }
         //salvando novo produto no pedido ou acresentando quantidade
         if (!$pedido->produtos->contains($produto->id)) {
            if ($peso == null) {
               $pedido->produtos()->save($produto, [
                  'quantidade'=>$quantidade,
                  'preco'=> $produto->preco,
                  'sub_total'=>$produto->preco * $request->input('quantidade'),
                  'peso'=>$peso
               ]);
            }else {
               $pedido->produtos()->save($produto, [
                  'quantidade'=>$quantidade,
                  'preco'=> $produto->preco,
                  'sub_total'=>($peso/1000) * $produto->preco,
                  'peso'=>$peso
               ]);
            }

         }else{
            $produto = $pedido->produtos()->where('produto_id',$produto->id)->first();
            //verificando se a quatidade é nula para classificar por peso
            if ($produto->pivot->quantidade ==null) {
               $pedido->produtos()->updateExistingPivot($produto->id, [
                  'quantidade'=>$quantidade,
                  'sub_total'=>(($peso/1000) * $produto->preco)+$produto->sub_total,
                  'preco'=> $produto->preco,
                  'peso'=>$peso + $produto->pivot->peso
               ]);
            }else {
               $pedido->produtos()->updateExistingPivot($produto->id, [
                  'quantidade'=>$request->input('quantidade') +
                  $produto->pivot->quantidade,
                  'sub_total'=> (($quantidade +
                  $produto->pivot->quantidade) * $produto->preco)+$produto->sub_total,
                  'preco'=> $produto->preco,
                  'peso'=>$peso + $produto->pivot->peso
               ]);
            }
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
      $pagamento->pago = true;
      $pagamento->data = Carbon::now();
      if ($forma == 0 ) {
         $pagamento->forma = "Dinheiro";
      }else {
         $pagamento->forma = "Cartão";
      }
      $pagamento->pedido()->associate($pedido);
      $pagamento->save();

      return redirect()->action('PDVController@index');
   }
   public function deletar($id)
   {
      $produto = \App\Pedido::findOrFail($id)->produtos()
      ->orderBy('pedido_produto.updated_at','desc')
      ->first();
      $pedido= \App\Pedido::findOrFail($id);
      if($produto->pivot->quantidade != null){
         $pedido->total -= $produto->pivot->quantidade * $produto->pivot->preco;
      }else{
         $pedido->total -= (($produto->pivot->peso/1000) * $produto->preco);
      }
      $pedido->produtos()->detach($produto->id);
      $pedido->save();
      return redirect()->action('PDVController@index');
   }
   public function autoComplete($query) {
      $produtos = \App\Produto::where('nome','like','%'.$query.'%')
      ->orwhere('cod_barras','like','%'.$query.'%')
      ->get();
      return $produtos->toJson();
   }
   public function peso($id)
   {
      $produto = \App\Produto::findOrFail($id);
      return $produto->toJson();
   }

}
