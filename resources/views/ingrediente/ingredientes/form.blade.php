<div class="form-group {{ $errors->has('produto') ? 'has-error' : ''}}">
    {!! Form::label('produto', 'Produtos', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('produto', $produtos, $produto_selecionado,['id'=>'select_produto']); !!}
        {!! $errors->first('produto', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('tipo') ? 'has-error' : ''}}">
    {!! Form::label('tipo', 'Tipo de Venda', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('tipo', ['Unidade','Peso'],0 ,['id'=>'tipo']); !!}
    </div>
</div>
<div id="peso" class="form-group {{ $errors->has('peso') ? 'has-error' : ''}}">
    {!! Form::label('peso', 'Peso', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('peso', null, ['class' => 'form-control']) !!}
        {!! $errors->first('peso', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div id="quantidade" class="form-group {{ $errors->has('quantidade') ? 'has-error' : ''}}">
    {!! Form::label('quantidade', 'Quantidade', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('quantidade', null, ['class' => 'form-control']) !!}
        {!! $errors->first('quantidade', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
