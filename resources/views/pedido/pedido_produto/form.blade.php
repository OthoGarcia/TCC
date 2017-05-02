<div class="form-group {{ $errors->has('produto') ? 'has-error' : ''}}">
    {!! Form::label('produto', 'Produto', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::select('produto', $produtos,$produto_selecionado,[ 'data-live-search'=>'true']); !!}
        {!! $errors->first('produto', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('quantidade') ? 'has-error' : ''}}">
    {!! Form::label('quantidade', 'Quantidade', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('quantidade', null, ['class' => 'form-control','id'=>'quantidade1',
         'onkeyup'=>'Gerar_sub_total(1);', 'onmouseup'=>'Gerar_sub_total(1);' ]) !!}
        {!! $errors->first('quantidade', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('preco') ? 'has-error' : ''}}">
    {!! Form::label('preco', 'Preco', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('preco', null, ['class' => 'form-control','id'=>'preco1',
         'onkeyup'=>'Gerar_sub_total(1);', 'onmouseup'=>'Gerar_sub_total(1);' ]) !!}
        {!! $errors->first('preco', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('sub_total') ? 'has-error' : ''}}">
    {!! Form::label('sub_total', 'Sub Total', ['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">
        {!! Form::number('sub_total', null, ['class' => 'form-control','id'=>'sub_total1','readonly']) !!}
        {!! $errors->first('sub_total', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>
</div>
