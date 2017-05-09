@extends('layouts.app')

@section('content')
    <div class="container  espaco-menu">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Role {{ $role->id }}</div>
                    <div class="panel-body">

                        <a href="{{ url('/role/roles') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/role/roles/' . $role->id . '/edit') }}" title="Edit Role"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['role/roles', $role->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger btn-xs',
                                    'title' => 'Delete Role',
                                    'onclick'=>'return confirm("Confirm delete?")'
                            ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $role->id }}</td>
                                    </tr>
                                    <tr><th> Nome </th><td> {{ $role->nome }} </td></tr><tr><th> Descricao </th><td> {{ $role->descricao }} </td></tr>
                                </tbody>
                            </table>
                            <div class="panel panel-default">
                               <div class="panel-heading">Permissões

                               </div>
                               <div class="panel-body">
                                  <div class="col-md-6">
                                     <ul>
                                        @foreach ($permissions as $permission)
                                        <li>
                                          {{ $permission->nome }}
                                        </li>
                                        @endforeach
                                     </ul>
                                     {!! $errors->first('permission', '<p class="help-block">:message</p>') !!}
                                  </div>
                               </div>
                            </div>

                            <div class="panel panel-default">
                               <div class="panel-heading">Usuarios

                               </div>
                               <div class="panel-body">
                                  <div class="col-md-6">
                                     <ul>
                                        @foreach ($users as $user)
                                        <li>
                                           {{ $user->name }}
                                        </li>
                                        @endforeach
                                     </ul>
                                     {!! $errors->first('user', '<p class="help-block">:message</p>') !!}
                                  </div>
                               </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
