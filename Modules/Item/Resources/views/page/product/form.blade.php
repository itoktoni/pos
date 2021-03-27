<x-editor />
<x-jscolor />

<div class="form-group">

    {!! Form::label('name', 'Category', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'item_category_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_category_id', $category, null, ['class'=> 'form-control ', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'item_category_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Product Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Buying Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'buy') ? 'has-error' : ''}}">
        {!! Form::number($form.'buy', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'buy', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Selling Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'sell') ? 'has-error' : ''}}">
        {!! Form::number($form.'sell', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'sell', '<p class="help-block">:message</p>') !!}
    </div>


</div>

<div class="form-group">
    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="mb-md col-md-10">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'id' => '', 'rows' => '5']) !!}
    </div>
</div>