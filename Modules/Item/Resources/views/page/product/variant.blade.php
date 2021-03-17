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

                <div class="col-md-2 col-ld-2 mb-sm">

                    <input type="hidden" name="item_detail_product_id" value="{{ $model->item_product_id }}">
                    <input type="hidden" name="item_detail_product_name" value="{{ $model->item_product_name }}">
                    <input type="hidden" name="item_detail_product_image" value="{{ $model->item_product_image }}">
                    <input type="hidden" name="item_detail_product_slug" value="{{ $model->item_product_slug }}">

                    <img width="100%" class="img-thumbnail"
                        src="{{ Helper::files($template.'/thumbnail_'.$model->item_product_image) }}" alt="">
                </div>

                <div class="col-md-10 col-lg-10">

                    <div class="form-group">

                        {!! Form::label('name', 'Custom Name', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('item_detail_name') ? 'has-error' : ''}}">
                            {!! Form::text('item_detail_name', $data->item_detail_name ?? null, ['class' =>
                            'form-control','placeholder' => $model->item_product_name.' Custom']) !!}
                            {!! $errors->first('item_detail_name', '<p class="help-block">:message</p>') !!}
                        </div>

                        {!! Form::label('name', 'Custom Price', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('item_detail_price') ? 'has-error' : ''}}">
                            {!! Form::text('item_detail_price', $data->item_detail_price ?? null, ['class' =>
                            'form-control', 'placeholder' =>
                            Helper::createRupiah($model->item_product_price)]) !!}
                            {!! $errors->first('item_detail_price', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group">

                    {!! Form::label('name', 'Branch', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('item_detail_branch_id') ? 'has-error' : ''}}">
                            {{ Form::select('item_detail_branch_id', $branch, $data->item_detail_branch_id ?? null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
                            {!! $errors->first('item_detail_branch_id', '<p class="help-block">:message</p>') !!}
                        </div>

                        {!! Form::label('name', 'Stock Qty', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('item_detail_stock_qty') ? 'has-error' : ''}}">
                            {!! Form::text('item_detail_stock_qty', $data->item_detail_stock_qty ?? null, ['class' =>
                            'form-control', ]) !!}
                            {!! $errors->first('item_detail_stock_qty', '<p class="help-block">:message</p>') !!}
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