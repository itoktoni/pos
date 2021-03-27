<x-date :array="['date']" />

@extends(Helper::setExtendBackend())
@section('content')
<div class="row">
    <div class="panel-body">
        {!! Form::open(['route' => $action_code, 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="panel panel-default">

            <header class="panel-heading">
                <h2 class="panel-title">Sync transaction</h2>
            </header>

            <div class="panel-body line">
                <div class="">

                    <table id="transaction" class="table table-no-more table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-left col-md-1">No. Order</th>
                                <th class="text-left col-md-4">Tanggal</th>
                                <th class="text-right col-md-1">Total</th>
                                <th class="text-right col-md-1">Bayar</th>
                                <th class="text-right col-md-1">Kembalian</th>
                            </tr>
                        </thead>
                        <tbody class="markup">
                            @foreach($order as $item)
                            <tr>
                                <td>
                                    {{ $item->sales_order_id ?? '' }}
                                </td>
                                <td>
                                    {{ $item->sales_order_updated_at ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{ $item->sales_order_sum_total ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{ $item->sales_order_sum_bayar ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{ $item->sales_order_sum_kembalian ?? '' }}
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