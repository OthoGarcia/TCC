@extends('layouts.app')

@section('content')
    <div class="container  espaco-menu">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Pedido Codigo:{{ $pedido->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/pedido/pedidos') }}" title="voltar"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> voltar</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($pedido, [
                            'method' => 'PATCH',
                            'url' => ['/pedido/pedidos', $pedido->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('pedido.pedidos.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
