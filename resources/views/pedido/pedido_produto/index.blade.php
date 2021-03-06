@extends('layouts.app')

@section('content')
    <div class="container  espaco-menu">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Pedido_produto</div>
                    <div class="panel-body">
                        <a href="{{ url('/pedido_produto/pedido_produto/create') }}" class="btn btn-success btn-sm" title="Add New pedido_produto">
                            <i class="fa fa-plus" aria-hidden="true"></i> Adicionar
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/pedido_produto/pedido_produto', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
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
                                        <th>ID</th><th>Quantidade</th><th>Preco</th><th>Sub Total</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($pedido_produto as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->quantidade }}</td><td>{{ $item->preco }}</td><td>{{ $item->sub_total }}</td>
                                        <td>
                                            <a href="{{ url('/pedido_produto/pedido_produto/' . $item->id) }}" title="View pedido_produto"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Vizualizar</button></a>
                                            <a href="{{ url('/pedido_produto/pedido_produto/' . $item->id . '/edit') }}" title="Edit pedido_produto"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/pedido_produto/pedido_produto', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Deletar', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Delete pedido_produto',
                                                        'onclick'=>'return confirm("Realmente deseja excluir este Pedido?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $pedido_produto->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
