@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      @if ($pedido->estado == 'Lista')
                          Lista de Compra {{ $pedido->id }}
                      @else
                          Pedido {{ $pedido->id }}
                      @endif
                     </div>
                    <div class="panel-body">

                        <a href="{{ url('/pedido/pedidos') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/pedido/pedidos/' . $pedido->id . '/edit') }}" title="Edit Pedido"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['pedido/pedidos', $pedido->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Pedido',
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
                        <div class="panel-heading">Produtos

                        </div>
                        <div class="panel-body">
                           {!! Form::open(['url' => '/pedido_produto/update/'.$pedido->id, 'class' => 'form-horizontal', 'files' => true]) !!}
                              <table class="table-bordered">
                                 <tr>
                                    <th>Produto</th>
                                    <th>Fornecedor</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Sub Total</th>
                                 </tr>
                                 @foreach ($produtos as $produto)
                                    <tr>
                                       <td>{{ $produto->nome}}</td>
                                       <td>{{ $produto->fornecedor->nome}}</td>
                                       <input type="hidden" name="produtos[]" value="{{ $produto->id }}">
                                       <td>{!! Form::number('quantidade[]', $produto->pivot->quantidade, ['class' => 'form-control','id'=>'quantidade'.$loop->iteration,
                                          'onkeyup'=>'Gerar_sub_total('.$loop->iteration.');', 'onmouseup'=>'Gerar_sub_total('.$loop->iteration.');',($pedido->estado == 'Efetuado' ? 'readonly' : 'focus') ]) !!}</td>
                                       <td>{!! Form::number('preco[]'.$produto->id, $produto->pivot->preco, ['class' => 'form-control','id'=>'preco'.$loop->iteration,
                                          'onkeyup'=>'Gerar_sub_total('.$loop->iteration.');', 'onmouseup'=>'Gerar_sub_total('.$loop->iteration.');',($pedido->estado == 'Efetuado' ? 'readonly' : 'focus') ]) !!}</td>
                                       <td> {!! Form::number('sub_total[]'.$produto->id, $produto->pivot->sub_total, ['class' => 'form-control','id'=>'sub_total'.$loop->iteration,'readonly']) !!}</td>
                                    </tr>
                                    <input type="hidden" name="" value="{{$loop->count}}" id='i'>
                                 @endforeach
                              </table>
                              {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Atualizar', array(
                                      'type' => 'submit',
                                      'class' => 'btn btn-primary btn-xs',
                                      'title' => 'Atualizar Valores Produtos',
                                      'onclick'=>'return confirm("Realmente Deseja Atualizar os Valores?")'
                              )) !!}
                              {!! Form::close() !!}
                              @if ($pedido->estado == 'Lista')
                                <a href="{{ url('/pedido/gerar/'.$pedido->id) }}" class="btn btn-success btn-sm" title="Add New Pedido">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Gerar Pedido
                                </a>
                              @endif
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
