<?php

namespace App\Http\Controllers\produto;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Produto;
use Illuminate\Http\Request;
use Session;

class ProdutosController extends Controller
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
            $produtos = Produto::where('nome', 'LIKE', "%$keyword%")
				->orWhere('descricao', 'LIKE', "%$keyword%")
				->orWhere('preco', 'LIKE', "%$keyword%")
				->orWhere('estoque_min', 'LIKE', "%$keyword%")

                ->paginate($perPage);
        } else {
            $produtos = Produto::paginate($perPage);
        }

        return view('produto.produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
      $cats = \App\Categoria::all();
      $categorias = array();
      foreach ($cats as $cat) {
         $categorias[$cat->id] = $cat->nome;
      }
      $categoria_selecionada = 1;
      $forns = \App\Fornecedor::all();
      $fornecedores = array();
      foreach ($forns as $forn) {
         $fornecedores[$forn->id] = $forn->nome;
      }
      $Fornecedor_selecionada = 1;
        return view('produto.produtos.create',compact('categorias','categoria_selecionada','fornecedores','Fornecedor_selecionada'));
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
         'nome' => 'required|max:255',
         'descricao' => 'required',
         'preco' => 'required',
         'estoque_min' => 'required',
      ]);
        $requestData = $request->all();

        $produto = Produto::create($requestData);
        $categoria = $request->input('categoria');
        $produto->categoria()->associate(\App\Categoria::findOrFail($categoria));
        $produto->save();
        Session::flash('flash_message', 'Produto added!');

        return redirect('produto/produtos');
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
        $produto = Produto::findOrFail($id);

        return view('produto.produtos.show', compact('produto'));
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

        $produto = Produto::findOrFail($id);
        $cats = \App\Categoria::all();
       $categorias = array();
       foreach ($cats as $cat) {
          $categorias[$cat->id] = $cat->nome;
       }
       $categoria_selecionada = $produto->categoria->id;
        return view('produto.produtos.edit', compact('produto','categorias','categoria_selecionada'));
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
      $this->validate($request, [
         'nome' => 'required|max:255',
         'descricao' => 'required',
         'preco' => 'required',
         'estoque_min' => 'required',
      ]);
        $requestData = $request->all();

        $produto = Produto::findOrFail($id);
        $produto->update($requestData);
        $categoria = $request->input('categoria');
        $produto->categoria()->associate(\App\Categoria::findOrFail($categoria));
        $produto->save();
        Session::flash('flash_message', 'Produto updated!');

        return redirect('produto/produtos');
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
        Produto::destroy($id);

        Session::flash('flash_message', 'Produto deleted!');

        return redirect('produto/produtos');
    }
}
