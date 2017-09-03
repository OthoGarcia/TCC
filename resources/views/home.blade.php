@extends('layouts.app')
@section('js')
<script src="{{ asset('js/home.js') }}"></script>
</script>
@endsection
@section('css')
   <link href="{{ URL::asset('css/home.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container espaco-menu">
    <div class="row">
        <div class="col-md-12">
           <div class="col-md-6 botoes">
             <h1 class="titulo">ATALHOS</h1>
             <hr>
             <div class="row">
                <div class="col-md-4">
                  <a href="{{ url('/pdv') }}" class="btn btn-success btn-lg" title="PONTO DE VENDA">
                      PDV
                  </a>
               </div>
               <div class="col-md-4">
                  <a href="{{ url('/pedido/pedidos') }}" class="btn btn-success btn-lg" title="PONTO DE VENDA">
                      PEDIDO
                  </a>
               </div>
             </div>
             <div class="row">
                <div class="col-md-4 botao">
               </div>
               <div class="col-md-4 botao">
               </div>
             </div>
           </div>
           <div class="col-md-6 avisos">
             <h1>Teste</h1>
           </div>
        </div>
    </div>
</div>
@endsection
