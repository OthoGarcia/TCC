<?php

namespace App\Http\Controllers\Ingrediente;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Ingrediente;
use Illuminate\Http\Request;
use Session;

class IngredientesController extends Controller
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
            $ingredientes = Ingrediente::where('peso', 'LIKE', "%$keyword%")
				->orWhere('quantidade', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $ingredientes = Ingrediente::paginate($perPage);
        }

        return view('ingrediente.ingredientes.index', compact('ingredientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
      $produtos = \App\Produto::get()->pluck('nome','id');
      $produto_selecionado = 0;
        return view('ingrediente.ingredientes.create',compact('produtos','produto_selecionado'));
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
          'quantidade'=>'required_if:tipo,==,0',
          'peso'=>'required_if:tipo,==,1'
      ]);
        $requestData = $request->all();

      $ingrediente =   Ingrediente::create($requestData);
      $ingrediente->produto()->associate(\App\Produto::findOrFail($request->input("produto")));
      $ingrediente->save();
        Session::flash('flash_message', 'Ingrediente added!');

        return redirect()->action('Ingrediente\\IngredientesController@createAdicionar', ['idIngrediante'=>$ingrediente->id]);
    }

    public function createAdicionar($idIngrediente){
      $ingrediente = Ingrediente::findOrFail($idIngrediente);
      $produtos = \App\Produto::get()->pluck('nome','id');
      $produto_selecionado = 0;
      return view('ingrediente.ingredientes.adicionar',compact('produtos','produto_selecionado','ingrediente'));
    }
    public function adicionar(Request $request){
      $ingrediente = Ingrediente::findOrFail($request->input('ingrediente'));
      $campos = [
         'quantidade' => $request->input('quantidade'),
         'peso' => $request->input('peso')
      ];
      $produto = \App\Produto::findOrFail($request->input('produto'));
      $ingrediente->produtos()->save($produto,$campos);
      $produtos = \App\Produto::get()->pluck('nome','id');
      $produto_selecionado = 0;
      return view('ingrediente.ingredientes.adicionar',compact('produtos','produto_selecionado','ingrediente'));
    }

    public function createMateriaPrima($idIngrediente)
    {
      $ingrediente = Ingrediente::findOrFail($idIngrediente);
      return view('ingrediente.ingredientes.materiaPrima',compact('ingrediente'));
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
        $ingrediente = Ingrediente::findOrFail($id);

        return view('ingrediente.ingredientes.show', compact('ingrediente'));
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
        $ingrediente = Ingrediente::findOrFail($id);

        return view('ingrediente.ingredientes.edit', compact('ingrediente'));
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

        $ingrediente = Ingrediente::findOrFail($id);
        $ingrediente->update($requestData);

        Session::flash('flash_message', 'Ingrediente updated!');

        return redirect('ingrediente/ingredientes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deletarItem($id,$idProduto)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        $ingrediente->produtos()->detach($idProduto);       
       $produtos = \App\Produto::get()->pluck('nome','id');
       $produto_selecionado = 0;
       return view('ingrediente.ingredientes.adicionar',compact('produtos','produto_selecionado','ingrediente'));
    }
    public function destroy($id)
    {
        Ingrediente::destroy($id);

        Session::flash('flash_message', 'Ingrediente deleted!');

        return redirect('ingrediente/ingredientes');
    }
}
