@extends('layouts.app')

@section('content')
    <div class="container  espaco-menu">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Categorias</div>
                    <div class="panel-body">
                        <a href="{{ url('/categoria/categorias/create') }}" class="btn btn-success btn-sm" title="Add New Categoria">
                            <i class="fa fa-plus" aria-hidden="true"></i> Adicionar
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/categoria/categorias', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Pesquisar">
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
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Descricao</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($categorias as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nome }}</td>
                                        <td class="table_descricao">{{ $item->descricao }}</td>
                                        <td>
                                            <a href="{{ url('/categoria/categorias/' . $item->id) }}" title="View Categoria"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Visualizar</button></a>
                                            <a href="{{ url('/categoria/categorias/' . $item->id . '/edit') }}" title="Edit Categoria"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/categoria/categorias', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Deletar', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Deletar Categoria',
                                                        'onclick'=>'return confirm("Deseja realmente deletar?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $categorias->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
