<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'phone') ? 'has-error' : ''}}">
        {!! Form::text($form.'phone', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'phone', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'description') ? 'has-error' : ''}}">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'description', '<p class="help-block">:message</p>') !!}
    </div>

</div>