@extends('layouts.app')

@section('content')
    <div class="container  espaco-menu">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Criar Fornecedor</div>
                    <div class="panel-body">
                        <a href="{{ url('/fornecedor/fornecedor') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        {!! Form::open(['url' => '/fornecedor/fornecedor', 'class' => 'form-horizontal', 'files' => true]) !!}

                        @include ('fornecedor.fornecedor.form')

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
