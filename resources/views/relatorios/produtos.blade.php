@extends('layouts.app')
@section('content')
    <div class="container  espaco-menu">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Produtos</div>
                    <div class="panel-body">
                        {!! Form::open(['method' => 'GET', 'url' => '/relatorio/produto', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
                        <div class="col-md-12">
                           <div class="col-md-12">
                              <div class="input-group">
                                  <input type="text" class="form-control" name="search" placeholder="Search...">
                                  <span class="input-group-btn">
                                      <button class="btn btn-default" type="submit">
                                          <i class="fa fa-search"></i>
                                      </button>
                                  </span>
                              </div>
                           </div>
                           <div class="col-md-4">
                               {!! Form::label('fornecedor', 'Fornecedor', ['class' => 'col-md-4 control-label']) !!}
                               <div class="col-md-8">
                                   {!! Form::select('fornecedor[]', $fornecedores, $fornecedor_selecionado, ['id'=>'select_fornecedor','multiple' => 'multiple']); !!}
                                   {!! $errors->first('fornecedor', '<p class="help-block">:message</p>') !!}
                               </div>
                           </div>
                           <div class="col-md-1">
                                   {!! Form::select( 'escolha', $escolhas,$escolha); !!}
                           </div>
                           <div class="col-md-4">
                               {!! Form::label('categoria', 'Categoria', ['class' => 'col-md-5 control-label']) !!}
                               <div class="col-md-6">
                                   {!! Form::select( 'categoria[]', $categorias,$categoria_selecionada, ['id'=>'select_categoria','multiple' => 'multiple']); !!}
                                   {!! $errors->first('categoria', '<p class="help-block">:message</p>') !!}
                               </div>
                           </div>

                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive table_relatorio">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>Nome</th><th>Descricao</th><th>Preco</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($produtos as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nome }}</td><td>{{ $item->descricao }}</td><td>{{ $item->preco }}</td>
                                        <td>
                                            <a href="{{ url('/produto/produtos/' . $item->id) }}" title="View Produto"><button class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Visualizar</button></a>
                                            <a href="{{ url('/produto/produtos/' . $item->id . '/edit') }}" title="Edit Produto"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button></a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/produto/produtos', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                                {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                                        'type' => 'submit',
                                                        'class' => 'btn btn-danger btn-xs',
                                                        'title' => 'Deletar Produto',
                                                        'onclick'=>'return confirm("Confirm delete?")'
                                                )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $produtos->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>

        $("#select_categoria").multipleSelect({
            filter: true,
            selectAll: false
        });
        $("#select_fornecedor").multipleSelect({
            filter: true,
            selectAll: false
        });
        $( "#select_categoria" ).change(function() {
           if (!jQuery.inArray( "0", $('#select_categoria').multipleSelect('getSelects'))) {
             $("#select_categoria").multipleSelect("uncheckAll");
           }
         });


         $( "#select_fornecedor" ).change(function() {
            if (!jQuery.inArray( "0", $('#select_fornecedor').multipleSelect('getSelects'))) {
              $("#select_fornecedor").multipleSelect("uncheckAll");
            }
          });

    </script>
@endsection
