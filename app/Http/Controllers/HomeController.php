<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $produtos = \App\Produto::where('quantidade','<','estoque_min');
        return view('home',compact('produtos'));
    }
    public function listaEstoque(){
      $produtos = \App\Produto::get();
      return $produtos->toJson();
    }
}
