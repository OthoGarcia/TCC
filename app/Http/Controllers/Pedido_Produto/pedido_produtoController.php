<?php

namespace App\Http\Controllers\Pedido_Produto;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\pedido_produto;
use Illuminate\Http\Request;
use Session;

class pedido_produtoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
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
      $prods = \App\Produto::all();
      $produtos = array();
      foreach ($prods as $prod) {
         $produtos[$prod->id] = $prod->nome . '  |  ' . $prod->fornecedor->nome;
      }
      $produto_selecionado = 0;
      $pedido = \App\Pedido::findOrFail($id);
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
      $pedido->produtos()->save($produto, [
         'quantidade'=>$quantidade,
         'preco'=> $preco,
         'sub_total'=>$sub_total
      ]);
        Session::flash('flash_message', 'pedido_produto added!');

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
