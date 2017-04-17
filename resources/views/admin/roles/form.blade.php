<div class="form-group {{ $errors->has('nome') ? 'has-error' : ''}}">
   {!! Form::label('nome', 'Nome', ['class' => 'col-md-4 control-label']) !!}
   <div class="col-md-6">
      {!! Form::text('nome', null, ['class' => 'form-control']) !!}
      {!! $errors->first('nome', '<p class="help-block">:message</p>') !!}
   </div>
</div>
<div class="form-group {{ $errors->has('descricao') ? 'has-error' : ''}}">
   {!! Form::label('descricao', 'Descricao', ['class' => 'col-md-4 control-label']) !!}
   <div class="col-md-6">
      {!! Form::textarea('descricao', null, ['class' => 'form-control']) !!}
      {!! $errors->first('descricao', '<p class="help-block">:message</p>') !!}
   </div>
</div>
<div class="panel panel-default">
   <div class="panel-heading">Permissões

   </div>
   <div class="panel-body">
      <div class="col-md-6">
         <ul>
            @foreach ($permissions as $permission)
            <li>
               {!! Form::checkbox('permissions[]', $permission->id) !!}
               {{ Form::label('permissions', $permission->nome) }}
            </li>
            @endforeach
         </ul>
         {!! $errors->first('permission', '<p class="help-block">:message</p>') !!}
      </div>
   </div>
</div>

<div class="form-group">
   <div class="col-md-offset-4 col-md-4">
      {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
   </div>
</div>
