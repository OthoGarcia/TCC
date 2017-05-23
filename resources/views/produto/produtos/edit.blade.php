@extends('layouts.app')

@section('content')
    <div class="container  espaco-menu">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Editar Produto #{{ $produto->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/produto/produtos') }}" title="Voltar"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($produto, [
                            'method' => 'PATCH',
                            'url' => ['/produto/produtos', $produto->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('produto.produtos.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
  <script src="{{ asset('js/produto.js') }}"></script>
@endsection
