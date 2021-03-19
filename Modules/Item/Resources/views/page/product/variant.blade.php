@extends(Helper::setExtendBackend())
@section('content')
<div class="row">

    <div class="panel-body">
        {!! Form::model($model, ['route'=>[$action_code, 'code' => $model->$key],'class'=>'form-horizontal
        ','files'=>true])
        !!}
        <div class="panel panel-default">

            <header class="panel-heading">
                <h2 class="panel-title">Detail Stock : {{ $model->item_product_name }}</h2>
            </header>

            <div class="panel-body line">

                <div class="col-md-12 col-lg-12">

                    <div class="form-group">

                        <input type="hidden" name="item_detail_product_id" value="{{ request()->get('code') }}">

                        {!! Form::label('name', 'Branch', ['class' => 'col-md-1 control-label']) !!}
                        <div class="col-md-3 {{ $errors->has('item_detail_branch_id') ? 'has-error' : ''}}">
                            {{ Form::select('item_detail_branch_id', $branch, $data->item_detail_branch_id ?? null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
                            {!! $errors->first('item_detail_branch_id', '<p class="help-block">:message</p>') !!}
                        </div>

                        {!! Form::label('name', 'Stock Qty', ['class' => 'col-md-1 control-label']) !!}
                        <div class="col-md-3 {{ $errors->has('item_detail_stock_qty') ? 'has-error' : ''}}">
                            {!! Form::text('item_detail_stock_qty', $data->item_detail_stock_qty ?? null, ['class' =>
                            'form-control', ]) !!}
                            {!! $errors->first('item_detail_stock_qty', '<p class="help-block">:message</p>') !!}
                        </div>

                        {!! Form::label('name', 'Stock Active', ['class' => 'col-md-1 control-label']) !!}
                        <div class="col-md-3 {{ $errors->has('item_detail_stock_enable') ? 'has-error' : ''}}">
                            {{ Form::select('item_detail_stock_enable', ['1' => 'Active', '0' => 'Non Active'], $data->item_detail_stock_enable ?? null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
                            {!! $errors->first('item_detail_stock_enable', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>

                </div>

            </div>

            @if(isset($detail) && !empty($detail))
            @include($folder.'::page.'.$template.'.table')
            @endif

            <input type="hidden" name="item_detail_id" value="{{ $data->item_detail_id ?? null }}">
            <div class="navbar-fixed-bottom" id="menu_action">
                <div class="text-right" style="padding:5px">

                    <a id="linkMenu" href="{!! route($module.'_data') !!}"
                        class="btn btn-warning">@lang('pages.back')</a>
                    <a class="btn btn-default"
                        href="{{ route($module.'_variant', ['code' => $model->{$model->getKeyName()}]) }}">Reset</a>
                    <button type="submit" class="btn btn-primary">@lang('pages.save')</button>

                </div>
            </div>

        </div>
        {!! Form::close() !!}

    </div>

</div>

@endsection