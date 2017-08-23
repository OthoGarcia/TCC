@extends('layouts.app')

@section('content')
    <div class="container espaco-menu">
        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Adicionar</div>
                    <div class="panel-body">
                        <a href="{{ url('/ingrediente/ingredientes') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                     
                    </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Ingredientes do Produto : {{$ingrediente->produto->nome}}</h3>
                  </div>
                  <div class="panel-body">
                     <div class="col-md-12">
                        <div class="col-md-6">
                           <span>Produto: {{$ingrediente->produto->nome}}</span>
                        </div>
                        <div class="col-md-6">
                           @if($ingrediente->peso == null)
                              <span>Quantidade Gerada: {{$ingrediente->quantidade}}</span>
                           @else
                              <span>Quantidade Gerada: {{$ingrediente->peso}}</span>
                           @endif
                        </div>
                     </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script type="text/javascript">
</script>
@endsection
