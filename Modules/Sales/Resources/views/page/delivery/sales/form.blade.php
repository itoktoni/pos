<div class="form-group">

    {!! Form::label('name', 'Vendor', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_to_id') ? 'has-error' : ''}}">
        {{ Form::select('sales_delivery_to_id', $customers, null, ['class'=> 'form-control', 'id' => 'to_id']) }}
        {!! $errors->first('sales_delivery_to_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Notes', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_notes_internal') ? 'has-error' : ''}}">
        {!! Form::textarea('sales_delivery_notes_internal', null, ['class' => 'form-control', 'rows' => 2]) !!}
        {!! $errors->first('sales_delivery_notes_internal', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

<div class="form-group">
    {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_status') ? 'has-error' : ''}}">
        {{ Form::select('sales_delivery_status', $status, null, ['class'=> 'form-control', 'id' => 'promo_id']) }}
        {!! $errors->first('sales_delivery_status', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Date', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('sales_delivery_date') ? 'has-error' : ''}}">
        {!! Form::text('sales_delivery_date', $model->sales_delivery_date ?? date('Y-m-d'), ['class' =>
        'form-control date']) !!}
        {!! $errors->first('sales_delivery_date', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<hr>

@include($folder.'::page.'.$template.'.sales.detail')
@include($folder.'::page.'.$template.'.sales.script')