<x-date :array="['date']" />

@extends(Helper::setExtendBackend())
@section('content')
<div class="row">
    <div class="panel-body">
        @isset($model->$key)
        {!! Form::model($model, ['route'=>[$action_code, 'code' => $model->$key],'class'=>'form-horizontal
        ','files'=>true])
        !!}
        @else
        {!! Form::open(['route' => $action_code, 'class' => 'form-horizontal', 'files' => true]) !!}
        @endisset
        <div class="panel panel-default">

            <header class="panel-heading">
                @isset($model->$key)
                <h2 class="panel-title">Edit {{ ucwords(str_replace('_',' ',$template)) }} : {{ $model->$key }}</h2>
                @else
                <h2 class="panel-title">Create {{ ucwords(str_replace('_',' ',$template)) }}</h2>
                @endisset
            </header>

            <div class="panel-body line">
                <div class="">


                    <div class="form-group">
                        {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('sales_delivery_status') ? 'has-error' : ''}}">
                            {{ Form::select('sales_delivery_status', ['1' => 'TRANSFER', '2' => 'RECEIVED'], null, ['class'=> 'form-control', 'id' => 'promo_id']) }}
                            {!! $errors->first('sales_delivery_status', '<p class="help-block">:message</p>') !!}
                        </div>

                        {!! Form::label('name', 'Date', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('sales_delivery_date') ? 'has-error' : ''}}">
                            {!! Form::text('sales_delivery_date', $model->sales_delivery_date ?? date('Y-m-d'), ['class'
                            =>
                            'form-control date']) !!}
                            {!! $errors->first('sales_delivery_date', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>

                    <hr>

                    <table id="transaction" class="table table-no-more table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left col-md-1">ID</th>
                                <th class="text-left col-md-2">Category</th>
                                <th class="text-left col-md-4">Product Name</th>
                                <th class="text-right col-md-1">Qty</th>
                                <th class="text-right col-md-1">Price</th>
                                <th class="text-right col-md-1">Total</th>
                            </tr>
                        </thead>
                        <tbody class="markup">
                            @foreach($model->detail as $item)
                            <tr>
                                <td>
                                    {{ $item->sales_delivery_detail_item_product_id ?? '' }}
                                </td>
                                <td>
                                    {{ $item->product->category->item_category_name ?? '' }}
                                </td>
                                <td>
                                    {{ $item->product->item_product_name ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{ $item->sales_delivery_detail_qty ?? '' }}
                                </td>

                                <td class="text-right">
                                    {{ Helper::createRupiah($item->sales_delivery_detail_price) ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{ Helper::createRupiah($item->sales_delivery_detail_total) ?? '' }}
                                </td>

                                <input type="hidden" value="{{ $item->sales_delivery_detail_item_product_id }}"
                                    name="detail[{{ $loop->index }}][id]">
                                <input type="hidden" value="{{ $item->product->category->item_category_id }}"
                                    name="detail[{{ $loop->index }}][category]">
                                <input type="hidden" value="{{ $item->sales_delivery_detail_qty }}"
                                    name="detail[{{ $loop->index }}][qty]">
                                <input type="hidden" value="{{ $item->sales_delivery_detail_price }}"
                                    name="detail[{{ $loop->index }}][price]">
                                <input type="hidden" value="{{$item->product->item_product_name ?? '' }}"
                                    name="detail[{{ $loop->index }}][name]">
                                <input type="hidden" value="{{ auth()->user()->branch }}"
                                    name="detail[{{ $loop->index }}][branch]">
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="5">
                                Total
                            </td>
                            <td class="text-right">
                                {{ Helper::createRupiah($model->sales_delivery_sum_total) }}
                            </td>
                        </tfoot>
                    </table>

                </div>
            </div>
            <div class="navbar-fixed-bottom" id="menu_action">
                <div class="text-right" style="padding:5px">
                    <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                    @if($action_function == 'update')
                    <a target="__blank" href="{!! route($module.'_print_order', ['code'=> $model->{$key}]) !!}"
                        class="btn btn-danger">PDF</a>
                    @endif
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

        </div>
        {!! Form::close() !!}

    </div>
</div>

@endsection
