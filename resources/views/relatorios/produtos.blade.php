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
                           <div class="col-md-12 pesquisa">
                              <div class="input-group">
                                  <input type="text" class="form-control" name="search" placeholder="Pesquisar Produto">
                                  <span class="input-group-btn">
                                      <button class="btn btn-default" type="submit">
                                          <i class="fa fa-search"></i>
                                      </button>
                                  </span>
                              </div>
                           </div>
                           <div class="col-md-4 col-md-offset-1">
                               {!! Form::label('fornecedor', 'Fornecedor', ['class' => 'col-md-4 control-label cabecalho_relatorio']) !!}
                               <div class="col-md-8">
                                   {!! Form::select('fornecedor[]', $fornecedores, $fornecedor_selecionado, ['id'=>'select_fornecedor','multiple' => 'multiple']); !!}
                                   {!! $errors->first('fornecedor', '<p class="help-block">:message</p>') !!}
                               </div>
                           </div>
                           <div class="col-md-2">
                                   {!! Form::select( 'escolha', $escolhas,$escolha); !!}
                           </div>
                           <div class="col-md-4">
                               {!! Form::label('categoria', 'Categoria', ['class' => 'col-md-6 control-label cabecalho_relatorio']) !!}
                               <div class="col-md-6">
                                   {!! Form::select( 'categoria[]', $categorias,$categoria_selecionada, ['id'=>'select_categoria','multiple' => 'multiple']); !!}
                                   {!! $errors->first('categoria', '<p class="help-block">:message</p>') !!}
                               </div>
                           </div>
                           <div class="col-md-3">
                               {!! Form::label('estoque_min', 'Estoque Vermelho', ['class' => 'col-md-11 control-label cabecalho_relatorio']) !!}
                                 {!! Form::checkbox('estoque_vermelho', '1',$estoque_vermelho); !!}
                           </div>

                        </div>
                        {!! Form::close() !!}
                        <hr>
                           <h2 class="relatorio">Relatório</h2>
                        <hr>
                           @foreach($produtos as $p)
                           <div class="col-md-12 relatorio_produtos">
                              <div class="col-md-2">
                                 <p>Codigo: <span>{{$p->cod_barras}}</span></p>
                              </div>
                              <div class="col-md-4">
                                 <p>Produto: <span>{{$p->nome}}</span></p>
                              </div>
                              <div class="col-md-4">
                                 <p>Categoria: <span>{{implode(',', $p->categorias->pluck('nome')->toArray())}}</span></p>
                              </div>
                              <div class="col-md-4">
                                 <p>fornecedor: <span>{{$p->fornecedor->nome}}</span></p>
                              </div>
                              <div class="col-md-3">
                                 <p>Preco Venda: <span>R$:{{$p->preco}}</span></p>
                              </div>
                              <div class="col-md-2">
                                 <p>Estoque: <span>{{$p->quantidade}}</span></p>
                              </div>
                              <div class="col-md-2">
                                 <p>Estoque Min: <span>{{$p->estoque_min}}</span></p>
                              </div>
                           </div>
                           <br>
                           @endforeach
                        <div class="pagination-wrapper"> {!! $produtos->appends(Request::except('page'))->links() !!} </div>
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
