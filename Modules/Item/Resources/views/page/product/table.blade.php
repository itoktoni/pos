<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-3">Shop</th>
            <th style="width: 50px;"  class="text-right col-md-1">Qty</th>
            <th style="width: 50px;" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody class="markup">
        @if(!empty($detail) || old('detail'))
        @foreach (old('detail') ?? $detail as $item)
        <tr>
            <td data-title="Shop" class="text-left col-lg-1">
                {{ $item->item_detail_branch_name }}
            </td>
            <td data-title="Price" class="text-right col-lg-1">
                {{ $item->item_detail_stock_qty }}
            </td>
            <td data-title="Action" class="text-center col-lg-2">
                <a class="btn btn-success btn-xs" href="{{ route($module.'_variant', ['code' => $model->{$model->getKeyName()}, 'id' => $item->item_detail_id]) }}">Edit</a>
                <a class="btn btn-danger btn-xs" href="{{ route($module.'_variant', ['code' => $model->{$model->getKeyName()}, 'del' => $item->item_detail_id]) }}">Delete</a>
            </td>
        </tr>
        @endforeach
        @endisset
    </tbody>

</table>