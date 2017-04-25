@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Pedido {{ $pedido->id }}</div>
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
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Sub Total</th>
                                 </tr>
                                 @foreach ($produtos as $produto)
                                    <tr>
                                       <td>{{ $produto->nome}}</td>
                                       <input type="hidden" name="produtos[]" value="{{ $produto->id }}">
                                       <td>{!! Form::number('quantidade[]', $produto->pivot->quantidade, ['class' => 'form-control','id'=>'quantidade'.$loop->iteration,
                                          'onkeyup'=>'sub_total('.$loop->iteration.');', 'onmouseup'=>'sub_total('.$loop->iteration.');' ]) !!}</td>
                                       <td>{!! Form::number('preco[]'.$produto->id, $produto->pivot->preco, ['class' => 'form-control','id'=>'preco'.$loop->iteration,
                                          'onkeyup'=>'sub_total('.$loop->iteration.');', 'onmouseup'=>'sub_total('.$loop->iteration.');' ]) !!}</td>
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
