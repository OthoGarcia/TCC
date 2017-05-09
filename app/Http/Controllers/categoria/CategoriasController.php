<?php

namespace App\Http\Controllers\categoria;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Categoria;
use Illuminate\Http\Request;
use Session;

class CategoriasController extends Controller
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
         $categorias = Categoria::where('nome', 'LIKE', "%$keyword%")
         ->orWhere('descricao', 'LIKE', "%$keyword%")

         ->paginate($perPage);
      } else {
         $categorias = Categoria::paginate($perPage);
      }

      return view('categoria.categorias.index', compact('categorias'));
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\View\View
   */
   public function create()
   {
      return view('categoria.categorias.create');
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
      ]);

      $requestData = $request->all();

      Categoria::create($requestData);

      Session::flash('flash_message', 'Categoria added!');

      return redirect('categoria/categorias');
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
      $categoria = Categoria::findOrFail($id);

      return view('categoria.categorias.show', compact('categoria'));
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
      $categoria = Categoria::findOrFail($id);

      return view('categoria.categorias.edit', compact('categoria'));
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
      ]);

      $requestData = $request->all();

      $categoria = Categoria::findOrFail($id);
      $categoria->update($requestData);

      Session::flash('flash_message', 'Categoria updated!');

      return redirect('categoria/categorias');
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
      Categoria::destroy($id);

      Session::flash('flash_message', 'Categoria deleted!');

      return redirect('categoria/categorias');
   }
}
