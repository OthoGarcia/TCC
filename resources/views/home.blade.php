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
             <h1 class="titulo">Alerta de Estoque</h1>
             <div class="col-md-12 exibindo_produtos">
                <table class="table">
                   <tr>
                      <th>Produto</th>
                      <th>Estoque Minimo</th>
                      <th>Estoque</th>
                   </tr>
                  @foreach($produtos as $p)
                  <tr>
                     <td>{{$p->nome}}</td>
                     <td>{{$p->estoque_min}}</td>
                     <td>{{$p->quantidade}}</td>
                  </tr>
                  @endforeach
               </table>
             </div>
           </div>
        </div>
    </div>
</div>
@endsection
