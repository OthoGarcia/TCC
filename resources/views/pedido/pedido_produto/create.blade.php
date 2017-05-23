@extends('layouts.app')

@section('content')
    <div class="container  espaco-menu">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New pedido_produto</div>
                    <div class="panel-body">
                        <a href="{{ url('/pedido/pedidos') }}" title="Voltar"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => '/pedido_produto/store/'.$pedido->id, 'class' => 'form-horizontal', 'files' => true]) !!}

                        @include ('pedido.pedido_produto.form')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
     @if (Session::get('popup') == 1)
       <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
          <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Este Produto já se encontra cadastrado, você deseja:</h2>
          </div>
          <div class="modal-body">
            <a href="{{ url('/pedido/duplicidade/'.$pedido->id.'/acrescentar') }}" title="Back"><button class="btn btn-primary btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Acrescentar</button></a>
            <p>ou</p>
            <a href="{{ url('/pedido/duplicidade/'.$pedido->id.'/substituir') }}" title="Back"><button class="btn btn-primary btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Substituir</button></a>
          </div>
        </div>
      </div>
   @endif
@endsection
@section('js')
  <script src="{{ asset('js/pedido.js') }}"></script>
@endsection
@section('css')
   <link href="{{ asset('css/pedido.css') }}" rel="stylesheet">
@endsection
