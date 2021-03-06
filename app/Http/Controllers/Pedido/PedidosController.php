<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Pedido;
use Illuminate\Http\Request;
use Session;
use PDF;
use Illuminate\Support\Facades\Input;
class PedidosController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\View\View
   */
   public function __construct()
   {
      $this->middleware('auth');
   }
   public function index(Request $request)
   {
      $keyword = $request->get('search');
      $perPage = 25;
      if (!empty($keyword)) {
         $pedidos = Pedido::where('descricao', 'LIKE', "%$keyword%")
         ->orWhere('estado', 'LIKE', "%$keyword%")
         ->where('estado','<>','Lista')
         ->paginate($perPage);
      } else {
         $pedidos = Pedido::where('estado','<>','Lista')
         ->orderBy('updated_at','desc')
         ->paginate($perPage);
      }
      session()->put('lista_pedido', '1');
      return view('pedido.pedidos.index', compact('pedidos'));
   }

   public function index_lista(Request $request)
   {
      $keyword = $request->get('search');
      $perPage = 25;

      if (!empty($keyword)) {
         $pedidos = Pedido::where('descricao', 'LIKE', "%$keyword%")
         ->orWhere('estado', 'LIKE', "%$keyword%")
         ->where('estado','=','Lista')

         ->paginate($perPage);
      } else {
         $pedidos = Pedido::where('estado','=','Lista')
         ->orderBy('updated_at','desc')
         ->paginate($perPage);
      }
      session()->put('lista_pedido', '0');
      return view('pedido.pedidos.index', compact('pedidos'));
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\View\View
   */
   public function create()
   {
      $prods = \App\Produto::all();
      $produtos = array();
      foreach ($prods as $prod) {
         $produtos[$prod->id] = $prod->nome . '  |  ' . $prod->fornecedor->nome;
      }
      $produto_selecionado = 0;
      return view('pedido.pedidos.create',compact('produtos','produto_selecionado'));
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
   public function store(Request $request)
   {
      $this->validate($request, [
          'descricao' => 'required|max:255'
      ]);
      $requestData = $request->all();
      if (session()->get('lista_pedido') == 0) {
         $requestData += ["estado"=>'Lista'];
      }else{
         $requestData += ["estado"=>'Aberto'];
      }

      Pedido::create($requestData);

      Session::flash('flash_message', 'Pedido added!');

      if (session()->get('lista_pedido') == 0) {
         return redirect('/pedido/lista');
      }else {
         return redirect('pedido/pedidos');
      }

   }
   /*
      Gerar o PDF do Pedido
   */
   public function efetuar_pedido($id)
   {
      $pedido = Pedido::findOrFail($id);
      $pedido->estado = 'Efetuado';
      $pedido->data_efetuado =  date('Y-m-d');
      $pedido->save();
      $produtos = $pedido->produtos;
      $data = date("d-m-Y", strtotime($pedido->updated_at));
      $pdf = PDF::loadView('pedido.pedidos.pedido',compact('pedido','produtos'))
       ->save(public_path().'/pedidos/pedido'.$pedido->id.'_'.$data.'.pdf');
      $pedido->arquivo = 'pedido'.$pedido->id.'_'.$data.'.pdf';
      $pedido->save();
      return redirect('pedido/pedidos');
   }
   public function visualizar_pedido($id)
   {
      $pedido = Pedido::findOrFail($id);
      return response()->file(public_path().'/pedidos/'.$pedido->arquivo);
   }

   public function entregue($id)
   {
      $pedido = Pedido::findOrFail($id);
      $pedido->estado = 'Entregue';
      $pedido->data_entregue =  date('Y-m-d');
      $pedido->save();
      return redirect('pedido/pedidos');
   }
   public function estoque_view($id){
      $pedido = Pedido::findOrFail($id);
      $produtos = $pedido->produtos;
      $pedido_produtos = $pedido->pivot;
      return view('pedido.pedidos.show', compact('pedido','produtos','pedido_produtos'));
   }
   public function estoque(Request $request,$id)
   {
      $requestData = $request->all();
      $pedido = Pedido::findOrFail($id);
      $produtos = $pedido->produtos;
      $produtos_entregues = Input::get('produtos');
      $finalizado = false;
      $i= 0;
      foreach ($produtos as $produto) {
         if (!empty($produtos_entregues)) {
            if (in_array($produto->id,$produtos_entregues)) {
               //alterando a quantidade no pedido efetuado para gerar um novo total
               $pedido_produto = [
                  'quantidade'=>$requestData['quantidade'][$i],
                  'preco'=> $requestData['preco'][$i],
                  'sub_total'=>$requestData['sub_total'][$i],
                  'entregue'=>true
               ];
               $pedido->produtos()->updateExistingPivot($produto->id, $pedido_produto);
               //adicionando a quantidade do pedido no estoque e alterando o preço de compra
               $produto->quantidade = $produto->quantidade + $produto->pivot->quantidade;
               if ($produto->peso != null) {
                  $produto->peso_quantidade = $produto->peso * $produto->quantidade;
               }
               $produto->save();
               $pedido->total = $pedido->total + $requestData['sub_total'][$i];
               $pedido->save();
            }
            $i++;
         }
      }
      //verificar ser todos os produtos estão corretos
      $produtos = Pedido::findOrFail($id)->produtos()->where('pedido_produto.entregue','=','0')->get();
      if ($produtos->count() == 0) {
         $pedido->estado = 'Finalizado';
         $pedido->save();
         Session::flash('pagamento', '1');
         Session::flash('pedido', $pedido->id);
         return redirect('pedido/pedidos');
      }
      return redirect('pedido/pedidos');
   }
   public function pagamento_compra(Request $request){
      $pedido = \App\Pedido::findOrFail($request->input('pedido'));
      $datas = $request->input('data');
      $parcela = $pedido->total/$request->input('vezes');
      if ($request->input('forma') == '0') {
         $forma = "Dinheiro";
      }else {
         $forma = "Cartão";
      }
      foreach ($datas as $i=>$data) {
         $pagamento = new \App\Pagamento;
         $pagamento->descricao = "Pagamento Referente ao  pedido número: " . $pedido->id .
         " Parcela número 1/".($request->input('vezes'));
         $pagamento->tipo = "Saída";
         $pagamento->valor = $parcela;
         $pagamento->data = $data;
         $pagamento->parcela = $i+1;
         $pagamento->forma = $forma;
         $pagamento->pago = false;
         $pagamento->pedido()->associate($pedido);
         $pagamento->save();
      }
      return redirect('pedido/pedidos');
   }
   public function pagamento_view($id){
      $pedido = Pedido::findOrFail($id);
      $pagamentos = $pedido->pagamentos;
      return view('pedido.pedidos.pagamento', compact('pedido','pagamentos'));
   }
   public function pagamento_parcela(Request $request, $id){
      $pedido = Pedido::findOrFail($id);
      $pagamentos = $pedido->pagamentos;
      $parcelas_pagas = Input::get('pagamentos');
      $finalizado = false;
      $i= 0;
      //dd($parcelas_pagas);
      foreach ($pagamentos as $pagamento) {
         if (!empty($parcelas_pagas)) {
            if (in_array($pagamento->id,$parcelas_pagas)) {
               $pagamento->pago = true;
               $pagamento->save();
            }
         }
      }
      $pagamentos = $pedido->pagamentos()->where('pago','=',false)->get();
      if ($pagamentos->count() == 0){
         $pedido->estado = 'Pago';
         $pedido->save();
      }
      return redirect('pedido/pedidos');
   }

   /**
   * Display the specified resource.
   *
   * @param  int  $id
   *
   * @return \Illuminate\View\View
   */
   public function show($id)
   {
      $pedido = Pedido::findOrFail($id);
      $produtos = $pedido->produtos;
      $pedido_produtos = $pedido->pivot;
      return view('pedido.pedidos.show', compact('pedido','produtos','pedido_produtos'));
   }
   public function gerar_pedido($id)
   {

      $produtos = Pedido::findOrFail($id)->produtos->groupBy('fornecedor_id');

      //$produtos = \App\Produto::all();

      foreach ($produtos as $produto) {
         $pedido = new Pedido;
         $pedido->descricao = "Pedido referente ao fornecedor: ".$produto->first()->fornecedor->nome;
         $pedido->estado = "Aberto";
         $pedido->save();
         $produtos = Pedido::findOrFail($id)->produtos()->where('fornecedor_id','=',$produto->first()->fornecedor->id);
         foreach ($produto as $item) {
            $pedido->fornecedor()->associate($item->fornecedor->id);
            $pedido->produtos()->save($item, [
               'quantidade'=>$item->pivot->quantidade,
               'preco'=> $item->pivot->preco,
               'sub_total'=>$item->pivot->sub_total
            ]);
         }
      }
      Pedido::destroy($id);
      return redirect()->action('Pedido\\PedidosController@index');

   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   *
   * @return \Illuminate\View\View
   */
   public function edit($id)
   {
      $pedido = Pedido::findOrFail($id);

      return view('pedido.pedidos.edit', compact('pedido'));
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @param \Illuminate\Http\Request $request
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
   public function update($id, Request $request)
   {

      $requestData = $request->all();

      $pedido = Pedido::findOrFail($id);
      $pedido->update($requestData);

      Session::flash('flash_message', 'Pedido updated!');

      return redirect('pedido/pedidos');
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   *
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
   */
   public function destroy($id)
   {
      Pedido::destroy($id);

      Session::flash('flash_message', 'Pedido deleted!');

      return redirect('pedido/pedidos');
   }
}
