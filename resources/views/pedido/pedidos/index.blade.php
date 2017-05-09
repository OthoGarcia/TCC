@extends('layouts.app')

@section('content')
    <div class="container  espaco-menu">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    @if (Session::get('lista_pedido') == 1)
                      Pedidos
                    @else
                      Lista de Compras
                    @endif

                    </div>
                    <div class="panel-body">
                        <a href="{{ url('/pedido/pedidos/create') }}" class="btn btn-success btn-sm" title="Add New Pedido">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>
                        {!! Form::open(['method' => 'GET', 'url' => '/pedido/pedidos', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Descricao</th>
                                        @if (Session::get('lista_pedido') == 1)
                                          <th>Fornecedor</th>
                                        @endif
                                        <th>Estado</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($pedidos as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->descricao }}</td>
                                        @if (Session::get('lista_pedido') == 1)
                                          @if ($item->fornecedor)
                                                <td>{{ $item->fornecedor->nome }}</td>
                                          @endif
                                        @endif
                                        <td>{{ $item->estado }}</td>
                                        <td>
                                           <!-- -->
                                           @if(($item->estado == 'Efetuado') or ($item->estado == 'Entregue') )
                                             <a  href="{{ route('visualizar_pedido', $item->id ) }}" target="_blank" title="View Pedido"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i>Visualizar</button></a>
                                           @else
                                             <a href="{{ url('/pedido/pedidos/' . $item->id) }}" title="View Pedido"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                           @endif
                                           @if (($item->estado == 'Efetuado'))
                                             <a href="{{ route('pedido_entregue', $item->id ) }}" title="View Pedido"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Entregue</button></a>
                                          @endif
                                          @if (($item->estado == 'Entregue'))
                                            <a href="{{ route('pedido_estoque_view', $item->id ) }}" title="View Pedido"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i>Adicionar Estoque</button></a>
                                         @endif
                                            @if(($item->estado == 'Aberto') or ($item->estado == 'Lista') )
                                               <a href="{{ url('/pedido/pedidos/' . $item->id . '/edit') }}" title="Edit Pedido"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                                               <a href="{{ url('/pedido_produto/' . $item->id) }}" title="Adicionar Produto"><button class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add</button></a>
                                               <a href="{{ url('pedido/efetuar/' . $item->id) }}" title="Adicionar Produto"><button class="btn btn-success btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Efetuar</button></a>
                                             @endif
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/pedido/pedidos', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete Pedido',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $pedidos->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
