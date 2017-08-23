@extends('layouts.app')

@section('content')
    <div class="container espaco-menu">
        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Adicionar</div>
                    <div class="panel-body">
                        <a href="{{ url('/ingrediente/ingredientes') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => '/ingrediente/adicionar', 'class' => 'form-horizontal', 'files' => true]) !!}
                        <input type="hidden" name="ingrediente" value="{{$ingrediente->id}}">
                           @include ('ingrediente.ingredientes.form')

                        {!! Form::close() !!}

                    </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Ingredientes do Produto : {{$ingrediente->produto->nome}}</h3>
                  </div>
                  <div class="panel-body">
                     <div class="col-md-12">
                        <h2>Receita</h2>

                        <table class="table table-condensed">
                           <thead>
                              <tr>
                                 <th>Produto</th>
                                 <th>Quantidade</th>
                                 <th>Excluir</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($ingrediente->produtos as $p)
                                 <tr>
                                    <td>{{$p->nome}}</td>
                                    @if($p->pivot->peso == null)
                                       <td> {{$p->pivot->quantidade}}</td>
                                    @else
                                       <td>{{$p->pivot->peso}}</td>
                                    @endif
                                    <td>{!! Form::open([                                        
                                        'url' => ['/ingrediente/item/deletar', $ingrediente->id,$p->id],
                                        'style' => 'display:inline'
                                    ]) !!}
                                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Deletar', array(
                                                'type' => 'submit',
                                                'class' => 'btn btn-danger btn-xs',
                                                'title' => 'Deletar Categoria',
                                                'onclick'=>'return confirm("Deseja realmente deletar?")'
                                        )) !!}
                                    {!! Form::close() !!}</td>
                                 </tr>
                                 @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function(){
     if ($("#tipo").val() == "0"){
       $("#peso").hide();
       $("#quantidade").show()
     }else{
       $("#peso").show();
       $("#quantidade").hide();
     }
     $('select').on('change', function() {
       if ($("#tipo").val() == "0"){
         $("#peso").hide();
         $("#quantidade").show();
       }else{
         $("#peso").show();
         $("#quantidade").hide();
       }
     });
});
</script>
@endsection
