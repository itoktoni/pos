<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left col-md-4">Product Name and Description</th>
            <th class="text-right col-md-1">Qty</th>
            <th class="text-right col-md-1">Price</th>
            <th class="text-right col-md-1">Total</th>
        </tr>
    </thead>
    <tbody class="markup">
        @if(!empty($detail) || old('detail'))
        @foreach (old('detail') ?? $detail as $item)
        <tr>
            <td data-title="Product">
                <input type="hidden" value="{{ $item['temp_id'] ?? $item->sales_order_detail_id }}"
                    name="detail[{{ $loop->index }}][temp_id]">
                <input type="hidden" value="{{ $item['temp_notes'] ?? $item->sales_order_detail_id }}"
                    name="detail[{{ $loop->index }}][temp_notes]">
                <input type="text" readonly class="form-control input-sm"
                    value="{{ $item['temp_product'] ?? $item->product->item_product_name }}"
                    name="detail[{{ $loop->index }}][temp_product]">
            </td>
            <td data-title="Qty" class="text-right col-lg-1">
                <input type="text" readonly tabindex="{{ $loop->iteration }}1"
                    name="detail[{{ $loop->index }}][temp_qty]" class="form-control input-sm text-right number"
                    value="{{ $item['temp_qty'] ?? $item->sales_order_detail_qty }}">
            </td>
            <td data-title="Price" class="text-right col-lg-1">

                <input type="hidden" tabindex="{{ $loop->iteration }}1" name="detail[{{ $loop->index }}][temp_sent]"
                    class="form-control input-sm text-right number temp_qty"
                    value="{{ $item['temp_sent'] ?? $item->sales_order_detail_sent }}">

                <input type="text" tabindex="{{ $loop->iteration }}2" readonly
                    name="detail[{{ $loop->index }}][temp_price]"
                    class="form-control input-sm text-right money temp_price"
                    value="{{ $item['temp_price'] ?? $item->sales_order_detail_price }}">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
                <input type="text" readonly name="detail[{{ $loop->index }}][temp_total]"
                    class="form-control input-sm text-right number temp_total"
                    value="{{ $item['temp_total'] ?? $item->sales_order_detail_total }}">
            </td>
        </tr>
        @endforeach
        @endisset
    </tbody>

    <tbody>
        <tr>
            <td data-title="Sebelum Discount" colspan="3" class="text-right">
                <strong>Total Sebelum Discount</strong>
            </td>
            <td data-title="" class="text-right">
                {!! Form::text('sales_order_sum_total', null, ['id' => 'before_discount',
                'readonly', 'class' => 'number form-control text-right']) !!}
            </td>
        </tr>
        <tr>
            <td data-title="Bayar" colspan="3" class="text-right">
                <strong>Bayar</strong>
            </td>
            <td data-title="" class="text-right">
                {!! Form::text('sales_order_sum_bayar', null, ['id' => 'grand_discount_value',
                'class' => 'number form-control text-right']) !!}
            </td>
        </tr>
        <tr>
            <td data-title="Kembalian" colspan="3" class="text-right">
                <strong>Kembalian</strong>
            </td>
            <td data-title="" class="text-right">
                {!! Form::text('sales_order_sum_kembalian', null, ['id' => 'grand_total',
                'readonly', 'class' => 'number form-control text-right']) !!}
            </td>
        </tr>
    </tbody>
</table>