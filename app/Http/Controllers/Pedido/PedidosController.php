<?php

namespace App\Http\Controllers\Pedido;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Pedido;
use Illuminate\Http\Request;
use Session;

class PedidosController extends Controller
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
            $pedidos = Pedido::where('descricao', 'LIKE', "%$keyword%")
				->orWhere('quantidade', 'LIKE', "%$keyword%")
				->orWhere('preco', 'LIKE', "%$keyword%")
				->orWhere('sub_total', 'LIKE', "%$keyword%")
				->orWhere('estado', 'LIKE', "%$keyword%")

                ->paginate($perPage);
        } else {
            $pedidos = Pedido::paginate($perPage);
        }

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

        $requestData = $request->all();
        $requestData += ["estado"=>'Aberto'];
        Pedido::create($requestData);

        Session::flash('flash_message', 'Pedido added!');

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

        return view('pedido.pedidos.show', compact('pedido'));
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
