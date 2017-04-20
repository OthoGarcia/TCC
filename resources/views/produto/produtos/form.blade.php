<div class="form-group {{ $errors->has('nome') ? 'has-error' : ''}}">
    {!! Form::label('nome', 'Nome', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::text('nome', null, ['class' => 'form-control']) !!}
        {!! $errors->first('nome', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('descricao') ? 'has-error' : ''}}">
    {!! Form::label('descricao', 'Descricao', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::textarea('descricao', null, ['class' => 'form-control']) !!}
        {!! $errors->first('descricao', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('categoria') ? 'has-error' : ''}}">
    {!! Form::label('categoria', 'Categoria', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('categoria', $categorias, $categoria_selecionada); !!}
        {!! $errors->first('categoria', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('fornecedor') ? 'has-error' : ''}}">
    {!! Form::label('fornecedor', 'Fornecedor', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('fornecedor', $fornecedores, $fornecedor_selecionada); !!}
        {!! $errors->first('fornecedor', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('tipo') ? 'has-error' : ''}}">
    {!! Form::label('tipo', 'Tipo de Venda', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('tipo', ['Unidade','Peso'],$tipo_selecionado ,['id'=>'tipo']); !!}
    </div>
</div>
<div id="peso" class="form-group {{ $errors->has('peso') ? 'has-error' : ''}}">
    {!! Form::label('peso', 'Peso da Unidade(Gramas)', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('peso', null, ['class' => 'form-control']) !!}
        {!! $errors->first('peso', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('preco') ? 'has-error' : ''}}">
    {!! Form::label('preco', 'Preco', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('preco', null, ['class' => 'form-control','step' => '0.1']) !!}
        {!! $errors->first('preco', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('estoque_min') ? 'has-error' : ''}}">
    {!! Form::label('estoque_min', 'Estoque Min', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('estoque_min', null, ['class' => 'form-control']) !!}
        {!! $errors->first('estoque_min', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary'],['id'=>'salvar']) !!}
    </div>
</div>
