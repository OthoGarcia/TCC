@extends('layouts.app')

@section('content')
    <div class="container  espaco-menu">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit pedido_produto #{{ $pedido_produto->id }}</div>
                    <div class="panel-body">
                        <a href="{{ url('/pedido_produto/pedido_produto') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::model($pedido_produto, [
                            'method' => 'PATCH',
                            'url' => ['/pedido_produto/pedido_produto', $pedido_produto->id],
                            'class' => 'form-horizontal',
                            'files' => true
                        ]) !!}

                        @include ('pedido.pedido_produto.form', ['submitButtonText' => 'Update'])

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
