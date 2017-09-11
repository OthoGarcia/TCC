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
         <div class="col-md-12">
               <a  class="btn btn-danger btn-sm sair" href="{{ url('/logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
               Sair
             </a>
             <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
             </form>
             <a href="{{ url('/home') }}" class="btn btn-danger btn-sm sair" title="Deletar Ultimo Item">
                Voltar Controle
             </a>
         </div>
        <div class="col-md-12 caixa">
          <div class="col-md-6 pesquisa">
            {!! Form::open(['url' => 'pdv/salvar', 'class' => 'form-horizontal', 'files' => true,'id'=>'pdv_form']) !!}<!--, "onSubmit"=>"return submit();" -->
               {!! Form::text('produto', null, ['class' => 'form-control autocomplete busca', 'id'=>'autocomplete','placeholder'=>'Buscar Produto']) !!}
               <ul>
                  <li>Para adicionar mais de 1 quantidade do mesmo produto, alterar a quantidade antes da busca</li>
               </ul>
               <div class="form-group {{ $errors->has('quantidade') ? 'has-error' : ''}}">
                   {!! Form::label('quantidade', 'QUANTIDADE (UN)', ['class' => 'col-md-4 control-label']) !!}
                   <div class="col-md-6">
                       {!! Form::number('quantidade', 1, ['class' => 'form-control campo','id'=>'quantidade1']) !!}
                       {!! $errors->first('quantidade', '<p class="help-block">:message</p>') !!}
                   </div>
               </div>
               <div class="form-group {{ $errors->has('preco') ? 'has-error' : ''}}">
                   {!! Form::label('preco', 'PREÇO (R$)', ['class' => 'col-md-4 control-label']) !!}
                   <div class="col-md-6">
                       {!! Form::number('preco', null, ['class' => 'form-control campo','id'=>'preco','step'=>"any", 'readonly' ]) !!}
                       {!! $errors->first('preco', '<p class="help-block">:message</p>') !!}
                   </div>
               </div>
               <div id="div_peso" class="form-group {{ $errors->has('preco') ? 'has-error' : ''}}">
                   {!! Form::label('peso', 'PESO (g)', ['class' => 'col-md-4 control-label']) !!}
                   <div class="col-md-6">
                       {!! Form::number('peso', null, ['class' => 'form-control campo','id'=>'peso','step'=>"any" ]) !!}
                       {!! $errors->first('peso', '<p class="help-block">:message</p>') !!}
                   </div>
               </div>
               <div class="form-group {{ $errors->has('preco') ? 'has-error' : ''}}">
                   {!! Form::label('total', 'TOTAL (R$)', ['class' => 'col-md-4 control-label']) !!}
                   <div class="col-md-6">
                       {!! Form::number('total', (isset($pedido)? $pedido->total : null), ['class' => 'form-control  campo','id'=>'total','step'=>"any", 'readonly' ]) !!}
                       {!! $errors->first('Total', '<p class="help-block">:message</p>') !!}
                   </div>
               </div>
            {!! Form::close() !!}
            @if(isset($pedido) and (count($pedido->produtos) > 0))
               <button id="finalizar" type="button" class="btn btn-info btn-lg" data-toggle="modal" title='Finalizar Pedido (ALT+3)' data-target="#myModal">Finalizar</button>
               <a id="deletar" href="{{ url('/deletar/'.$pedido->id) }}" class="btn btn-danger btn-lg" title="Deletar Ultimo Item Inserido (ALT+2)">
                  Deletar
               </a>
            @endif
          </div>
          <div class="col-md-6 produtos">
             @if(isset($produtos))
               <table class="printer-ticket">
                  <thead>
                     <tr>
                        <th class="title" colspan="3">Padaria Pão Quentinho</th>
                     </tr>
                     <tr>
                        <th colspan="3">{{$data}}</th>
                     </tr>
                     <tr>
                        <th class="ttu" colspan="3">
                           <b>Cupom</b>
                        </th>
                     </tr>
                  </thead>
                  <tbody class="corpo_cupom" id="cupom">

                     @foreach ($produtos as $p)
                     <tr id="n_{{$p->cod_barras}}" class="top">
                        <td colspan="3">{{$p->nome}}</td>
                     </tr>
                     <tr id="{{$p->cod_barras}}">
                        <td id="preco_cupom">R$: {{$p->preco}}</td>
                        @if($p->pivot->quantidade == null)
                           <td >{{$p->pivot->peso}}g</td>
                        @else
                           <td id="quantidade_cupom">{{$p->pivot->quantidade}}un</td>
                        @endif
                        <td id="preco_subtotal">R$: {{number_format($p->pivot->sub_total,2)}}</td>
                     </tr>
                     @endforeach
                  </tbody>
                  <tfoot>
                     <tr class="sup ttu p--0">
                        <td colspan="3">
                           <b>Total</b>
                        </td>
                     </tr>
                     <tr class="ttu">
                        <td colspan="2">Sub-total</td>
                        <td id="cupom_subTotal" align="right">{{$sub_total}}</td>
                     </tr>
                     <tr class="sup">
                        <td colspan="3" align="center">
                           www.caderninho.com/NF-E
                        </td>
                     </tr>
                  </tfoot>
                  </table>
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
           <div class="col-md-12">
              <div class="col-md-12">
                 <div class="panel panel-default">
                     <div class="panel-heading">Dinheiro</div>
                     <div class="panel-body">
                        <div class="col-md-7">
                           <div class="form-group {{ $errors->has('preco') ? 'has-error' : ''}}">
                               {!! Form::label('total_pagamento', 'Total', ['class' => 'col-md-4 control-label']) !!}
                               <div class="col-md-6">
                                   {!! Form::number('total_pagamento', null, ['class' => 'form-control','id'=>'total_pagamento','step'=>"any",'readonly'=>'true' ]) !!}
                               </div>
                           </div>
                           <div class="form-group {{ $errors->has('preco') ? 'has-error' : ''}}">
                               {!! Form::label('valor', 'valor', ['class' => 'col-md-4 control-label']) !!}
                               <div class="col-md-6">
                                   {!! Form::number('valor', null, ['class' => 'form-control','id'=>'valor','step'=>"any" ]) !!}
                               </div>
                           </div>
                        </div>
                        <div class="col-md-7">
                           <div class="form-group {{ $errors->has('preco') ? 'has-error' : ''}}">
                               {!! Form::label('troco', 'troco', ['class' => 'col-md-4 control-label']) !!}
                               <div class="col-md-6">
                                   {!! Form::number('troco', null, ['class' => 'form-control','id'=>'troco','step'=>"any", 'readonly' ]) !!}
                               </div>
                           </div>
                        </div>
                        <div class="col-md-7">
                           <a id="pagar" href="{{ url('/finalizar/'.$pedido->id.'/0') }}" class="btn btn-success " title="Finalizar Pedido">
                              Pagar
                          </a>
                        </div>
                     </div>
                  </div>
              </div>
              <div class="col-md-12">
                 <a href="{{ url('/finalizar/'.$pedido->id.'/1') }}" class="btn btn-success btn-sm" title="Finalizar Pedido">
                     <i class="fa fa-plus" aria-hidden="true"></i> Cartão
                 </a>
               </div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>
@endif
</body>
</html>
