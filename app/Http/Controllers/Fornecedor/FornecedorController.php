<?php

namespace App\Http\Controllers\Fornecedor;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Fornecedor;
use Illuminate\Http\Request;
use Session;

class FornecedorController extends Controller
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
            $fornecedor = Fornecedor::where('nome', 'LIKE', "%$keyword%")
				->orWhere('descricao', 'LIKE', "%$keyword%")
				->orWhere('telefone', 'LIKE', "%$keyword%")
				->orWhere('email', 'LIKE', "%$keyword%")

                ->paginate($perPage);
        } else {
            $fornecedor = Fornecedor::paginate($perPage);
        }

        return view('fornecedor.fornecedor.index', compact('fornecedor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('fornecedor.fornecedor.create');
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
         'telefone' => 'required',
         'email' => 'required',
      ]);
        $requestData = $request->all();

        Fornecedor::create($requestData);

        Session::flash('flash_message', 'Fornecedor added!');

        return redirect('fornecedor/fornecedor');
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
        $fornecedor = Fornecedor::findOrFail($id);

        return view('fornecedor.fornecedor.show', compact('fornecedor'));
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
        $fornecedor = Fornecedor::findOrFail($id);

        return view('fornecedor.fornecedor.edit', compact('fornecedor'));
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
         'telefone' => 'required',
         'email' => 'required',
      ]);
        $requestData = $request->all();

        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->update($requestData);

        Session::flash('flash_message', 'Fornecedor updated!');

        return redirect('fornecedor/fornecedor');
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
        Fornecedor::destroy($id);

        Session::flash('flash_message', 'Fornecedor deleted!');

        return redirect('fornecedor/fornecedor');
    }
}
