<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta nome="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta nome="csrf-token" content="{{ csrf_token() }}">

  <title>Essential Technologies</title>

  <!-- Styles2 -->

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/pdv.css') }}" rel="stylesheet">
  <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('css/hover-min.css') }}" rel="stylesheet">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="all">
  <!--
  <script>

  window.Laravel = <?php echo json_encode([
  'csrfToken' => csrf_token(),
]); ?>

</script>
Scripts -->
</head>
<body>
  <div id="app">
    <div class="container">
      <div class="row">
        <div class="col-md-12 caixa">
          <div class="col-md-6 pesquisa">
            {!! Form::open(['url' => 'pdv/salvar', 'class' => 'form-horizontal', 'files' => true,'id'=>'pdv_form', "onSubmit"=>"return submit();"]) !!}
               {!! Form::text('produto', null, ['class' => 'form-control autocomplete', 'id'=>'autocomplete','placeholder'=>'Buscar Produto']) !!}
               <div class="form-group {{ $errors->has('quantidade') ? 'has-error' : ''}}">
                   {!! Form::label('quantidade', 'Quantidade', ['class' => 'col-md-4 control-label']) !!}
                   <div class="col-md-6">
                       {!! Form::number('quantidade', 1, ['class' => 'form-control','id'=>'quantidade1']) !!}
                       {!! $errors->first('quantidade', '<p class="help-block">:message</p>') !!}
                   </div>
               </div>
               <div class="form-group {{ $errors->has('preco') ? 'has-error' : ''}}">
                   {!! Form::label('preco', 'Preco', ['class' => 'col-md-4 control-label']) !!}
                   <div class="col-md-6">
                       {!! Form::number('preco', null, ['class' => 'form-control','id'=>'preco','step'=>"any", 'readonly' ]) !!}
                       {!! $errors->first('preco', '<p class="help-block">:message</p>') !!}
                   </div>
               </div>
               <div id="div_peso" class="form-group {{ $errors->has('preco') ? 'has-error' : ''}}">
                   {!! Form::label('peso', 'Peso', ['class' => 'col-md-4 control-label']) !!}
                   <div class="col-md-6">
                       {!! Form::number('peso', null, ['class' => 'form-control','id'=>'peso','step'=>"any" ]) !!}
                       {!! $errors->first('peso', '<p class="help-block">:message</p>') !!}
                   </div>
               </div>
               <div class="form-group {{ $errors->has('preco') ? 'has-error' : ''}}">
                   {!! Form::label('total', 'Total', ['class' => 'col-md-4 control-label']) !!}
                   <div class="col-md-6">
                       {!! Form::number('total', (isset($pedido)? $pedido->total : null), ['class' => 'form-control','id'=>'preco','step'=>"any", 'readonly' ]) !!}
                       {!! $errors->first('Total', '<p class="help-block">:message</p>') !!}
                   </div>
               </div>                
            {!! Form::close() !!}
            @if(isset($pedido))
               <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Finalizar</button>
               <a href="{{ url('/deletar/'.$pedido->id) }}" class="btn btn-success btn-sm" title="Finalizar Pedido">
                   <i class="fa fa-plus" aria-hidden="true"></i> Deletar
               </a>
            @endif
          </div>
          <div class="col-md-6 produtos">
             @if(isset($produtos))
               @foreach ($produtos as $produto)
                  <span>{{ $produto->pivot->quantidade }}</span>
                  <span>{{ $produto->nome }}</span>
                  <span>R$: {{ $produto->preco }}</span>
                  <br>
               @endforeach
             @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/pdv.js') }}"></script>
<script src="{{ asset('js/bootstrap-3-3-7.min.js') }}"></script>
<div class="modal fade" id="myModal" role="dialog">
@if(isset($pedido))
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Forma de Pagamento</h4>
        </div>
        <div class="modal-body">
           <a href="{{ url('/finalizar/'.$pedido->id.'/0') }}" class="btn btn-success btn-sm" title="Finalizar Pedido">
               <i class="fa fa-plus" aria-hidden="true"></i> Dinheiro
           </a>
           <a href="{{ url('/finalizar/'.$pedido->id.'/1') }}" class="btn btn-success btn-sm" title="Finalizar Pedido">
               <i class="fa fa-plus" aria-hidden="true"></i> Cartão
           </a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>
@endif
</body>
</html>
