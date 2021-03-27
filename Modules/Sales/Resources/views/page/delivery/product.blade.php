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
                    <button onclick="return confirm('Are you sure to sync data ?');"  type="submit" class="btn btn-primary">Sync</button>
                </div>
            </div>

        </div>
        {!! Form::close() !!}

    </div>
</div>

@endsection