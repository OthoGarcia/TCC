@extends('layouts.app')

@section('content')
    <div class="container  espaco-menu">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      @if ($pedido->estado == 'Lista')
                          Lista de Compra {{ $pedido->id }}
                      @else
                          Pedido {{ $pedido->id }}
                      @endif
                     </div>
                    <div class="panel-body">

                        <a href="{{ url('/pedido/pedidos') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</button></a>
                        <a href="{{ url('/pedido/pedidos/' . $pedido->id . '/edit') }}" title="Editar Pedido"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>
                        <!-- Não poder deletar o pedido
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['pedido/pedidos', $pedido->id],
                            'style' => 'display:inline'
                        ]) !!}
                     -->
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Deletar', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Deletar Pedido',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                         <table class="table table-borderless">
                             <tbody>
                                 <tr>
                                     <th>ID</th><td>{{ $pedido->id }}</td>
                                 </tr>
                                 <tr>
                                    <th> Descricao </th>
                                    <td> {{ $pedido->descricao }} </td>
                                 </tr>
                             </tbody>
                         </table>
                     </div>
                     <div class="panel panel-default">
                        <div class="panel-heading">Pagamentos

                        </div>
                        <div class="panel-body">
                           {!! Form::open(['url' => '/pedido/pagamento/parcela/'.$pedido->id, 'class' => 'form-horizontal', 'files' => true]) !!}
                              <table class="table-bordered">
                                 <tr>
                                    <th>Pagar</th>
                                    <th>Data</th>
                                    <th>Valor</th>
                                 </tr>
                                 @foreach ($pagamentos as $pagamento)
                                    <tr>
                                       @if($pedido->estado == 'Finalizado' and (!$pagamento->pago))
                                          <td>
                                             {!! Form::checkbox('pagamentos[]', $pagamento->id) !!}
                                          </td>
                                       @elseif($pagamento->pago)
                                          <td>
                                             OK!
                                          </td>
                                       @endif
                                       <td>{{ $pagamento->data }}</td>
                                       <td>{{ $pagamento->valor }}</td>
                                       <!-- Se ja foi feita a contagem no estoque não pode haver mais mudanças-->
                                    </tr>
                                    <input type="hidden" name="" value="{{$loop->count}}" id='i'>
                                 @endforeach
                              </table>
                              @if ($pedido->estado == 'Finalizado')
                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Atualizar', array(
                                        'type' => 'submit',
                                        'class' => 'btn btn-primary btn-xs',
                                        'title' => 'Atualizar Valores Produtos',
                                        'onclick'=>'return confirm("Realmente Deseja Atualizar os Valores?")'
                                )) !!}
                              @endif
                              {!! Form::close() !!}

                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
   <link href="{{ asset('css/pedido.css') }}" rel="stylesheet">
@endsection
@section('js')
  <script src="{{ asset('js/pedido.js') }}"></script>
@endsection
