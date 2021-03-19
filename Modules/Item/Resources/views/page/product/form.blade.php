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
    {!! Form::label('name', 'Default Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'price') ? 'has-error' : ''}}">
        {!! Form::number($form.'price', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'price', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Minimum Stock', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'min_stock') ? 'has-error' : ''}}">
        {!! Form::number($form.'min_stock', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'min_stock', '<p class="help-block">:message</p>') !!}
    </div>


</div>

<div class="form-group">
    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="mb-md col-md-10">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'id' => '', 'rows' => '5']) !!}
    </div>
</div>