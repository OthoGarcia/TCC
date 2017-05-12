<?php

namespace App\Http\Controllers\Pedido_Produto;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\pedido_produto;
use Illuminate\Http\Request;
use Session;
use App\Produto;
use App\Fornecedor;

class pedido_produtoController extends Controller
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
            $pedido_produto = pedido_produto::where('quantidade', 'LIKE', "%$keyword%")
				->orWhere('preco', 'LIKE', "%$keyword%")
				->orWhere('sub_total', 'LIKE', "%$keyword%")

                ->paginate($perPage);
        } else {
            $pedido_produto = pedido_produto::paginate($perPage);
        }

        return view('pedido.pedido_produto.index', compact('pedido_produto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
      $pedido = \App\Pedido::findOrFail($id);
      //lista_pedido é para verificar se é pedido ou lista de compras
      // 1 = pedido | 0 = lista
      if (!$pedido->produtos->isEmpty()) {
         if (session()->get('lista_pedido') == 1) {
            $produto = $pedido->produtos->first();
            $prods = \App\Produto::where('fornecedor_id','=',$produto->fornecedor->id)
            ->orderBy('nome')
            ->get();

            $produtos = array();
            foreach ($prods as $prod) {
               $produtos[$prod->id] = $prod->nome . '  |  ' . $prod->fornecedor->nome;
            }
         }else{
            $prods = \App\Produto::
            orderBy('nome')->get();
            $produtos = array();
            foreach ($prods as $prod) {
               $produtos[$prod->id] = $prod->nome . '  |  ' . $prod->fornecedor->nome;
            }
         }
      }else{
         $prods = \App\Produto::orderBy('nome')->get();
         $produtos = array();
         foreach ($prods as $prod) {
            $produtos[$prod->id] = $prod->nome . '  |  ' . $prod->fornecedor->nome;
         }
      }
      if (session()->get('popup') == '1') {
         Session::flash('popup', '1');
      }
         $produto_selecionado = 0;
        return view('pedido.pedido_produto.create',compact('pedido','produtos','produto_selecionado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, $id)
    {
      $this->validate($request, [
          'preco' => 'required',
          'quantidade' => 'required',
          'sub_total'=>'required'
      ]);
        $requestData = $request->all();
      $quantidade = $request->input('quantidade');
      $preco = $request->input('preco');
      $sub_total = $request->input('sub_total');
      $pedido = \App\Pedido::findOrFail($id);

      $produto = \App\Produto::findOrFail($request->input('produto'));
      if ($pedido->fornecedor == null) {
         $fornecedor = \App\Fornecedor::findOrFail($produto->fornecedor->id);
         $pedido->fornecedor()->associate($fornecedor);
         $pedido->save();
      }
      //se o pedido ainda n possui o produto, o mesmo é adicionado
      if (!$pedido->produtos->contains($produto->id)) {
         $pedido->produtos()->save($produto, [
            'quantidade'=>$quantidade,
            'preco'=> $preco,
            'sub_total'=>$sub_total,
            'entregue'=>false
         ]);
      }else{
         Session::flash('popup', '1');
         Session::put([
            'id'=>$produto->id,
            'quantidade'=>$quantidade,
            'preco'=> $preco,
            'sub_total'=>$sub_total
         ]);
         return redirect()->action(
           'Pedido_Produto\\pedido_produtoController@create', ['id' => $pedido->id]
          );
      }
        Session::flash('flash_message', 'pedido_produto added!');

        return redirect('pedido/pedidos');
    }
   public function duplicidade($id,$acao){
      $pedido_produto = [
         'quantidade'=>session()->get('quantidade'),
         'preco'=>session()->get('preco'),
         'sub_total'=>session()->get('sub_total')
      ];

      $pedido = \App\Pedido::findOrFail($id);
      if ($acao == 'substituir') {
         $pedido->produtos()->updateExistingPivot(session()->get('id'), $pedido_produto);
      }else{
         $produto = $pedido->produtos->find(session()->get('id'));
         $pedido_produto['quantidade'] = $pedido_produto['quantidade'] + $produto->pivot->quantidade;
         $pedido_produto['sub_total'] = $pedido_produto['quantidade'] * $pedido_produto['preco'];
         $pedido->produtos()->updateExistingPivot(session()->get('id'), $pedido_produto);
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
         $produtos = $pedido->produtos();
        return view('pedido.pedido_produto.show', compact('pedido','produtos'));
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
        $pedido_produto = pedido_produto::findOrFail($id);

        return view('pedido.pedido_produto.edit', compact('pedido_produto'));
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

        $pedido = \App\Pedido::findOrFail($id);
        $pedido_produto = $pedido->pivot;
        $produtos = $request->input('produtos');
        //dd($requestData['quantidade'][0]);
        $i = 0;
        foreach ($requestData['quantidade'] as $rd) {
          $pedido->produtos()->updateExistingPivot($requestData['produtos'][$i],
            [
               'quantidade'=> $requestData['quantidade'][$i],
               'preco' => $requestData['preco'][$i],
               'sub_total' => $requestData['sub_total'][$i]
            ]
         );
         $i++;
        }

        return redirect()->action(
          'Pedido\\PedidosController@show', ['id' => $pedido->id]
         );
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
        pedido_produto::destroy($id);

        Session::flash('flash_message', 'pedido_produto deleted!');

        return redirect('pedido_produto/pedido_produto');
    }
}
