<x-date :array="['date']" />

@extends(Helper::setExtendBackend())
@section('content')
<div class="row">
    <div class="panel-body">
        {!! Form::open(['route' => $action_code, 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="panel panel-default">

            <header class="panel-heading">
                <h2 class="panel-title">Sync Product</h2>
            </header>



            <div class="panel-body line">
                <div class="">


                    <div class="form-group">
                        {!! Form::label('name', 'Date From', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('from') ? 'has-error' : ''}}">
                            {!! Form::text('from', $model->from ?? date('Y-m-d'), ['class'
                            =>
                            'form-control date']) !!}
                            {!! $errors->first('from', '<p class="help-block">:message</p>') !!}
                        </div>

                        {!! Form::label('name', 'Date To', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('to') ? 'has-error' : ''}}">
                            {!! Form::text('to', $model->to ?? date('Y-m-d'), ['class'
                            =>
                            'form-control date']) !!}
                            {!! $errors->first('to', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>

                    <table id="transaction" class="table table-no-more table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left col-md-1">ID</th>
                                <th class="text-left col-md-4">Product Name and Description</th>
                                <th class="text-right col-md-1">Qty</th>
                            </tr>
                        </thead>
                        <tbody class="markup">
                            @foreach($product as $item)
                            <tr>
                                <td>
                                    {{ $item->item_product_id ?? '' }}
                                </td>
                                <td>
                                    {{ $item->item_product_name ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{ $item->detail->sum('item_detail_stock_qty') ?? '' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="navbar-fixed-bottom" id="menu_action">
                <div class="text-right" style="padding:5px">
                    <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                    <button type="submit" name="pdf" class="btn btn-danger">PDF</button>
                    <button name="sync" onclick="return confirm('Are you sure to sync data ?');" type="submit"
                        class="btn btn-primary">Sync</button>
                </div>
            </div>

        </div>
        {!! Form::close() !!}

    </div>
</div>

@endsection