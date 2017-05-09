@extends('layouts.app')

@section('content')
    <div class="container  espaco-menu">
        <div class="row">


            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Fornecedor {{ $fornecedor->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/fornecedor/fornecedor') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/fornecedor/fornecedor/' . $fornecedor->id . '/edit') }}" title="Edit Fornecedor"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['fornecedor/fornecedor', $fornecedor->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Fornecedor',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $fornecedor->id }}</td>
                                    </tr>
                                    <tr><th> Nome </th><td> {{ $fornecedor->nome }} </td></tr><tr><th> Descricao </th><td> {{ $fornecedor->descricao }} </td></tr><tr><th> Telefone </th><td> {{ $fornecedor->telefone }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
