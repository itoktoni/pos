<div class="summary mb-6">
    <table class="order-table">
        <thead>
            <tr>
                <th colspan="2" class="text-left">{{ $cart[0]->branch_name ?? '' }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $item)
            <tr>
                <td class="product-detail">
                    <span>{{ $item->product_name ?? '' }}</span>
                    <strong class="product-quantity">×&nbsp;{{ $item->qty ?? '' }}</strong>
                    <ul class="variant">
                        @if(!empty($item->color_name))
                        <li class="text-grey">{{ $item->color_name ?? '' }}</li>
                        @endif
                        @if(!empty($item->size_name))
                        <li class="text-grey">{{ $item->size_name ?? '' }}</li>
                        @endif
                        @if(!empty($item->variant_name))
                        <li class="text-grey">{{ $item->variant_name ?? '' }}</li>
                        @endif
                    </ul>
                </td>
                <td class="product-total">{{ isset($item->total) ? Helper::createRupiah($item->total) : '' }}</td>
            </tr>
            @endforeach
            <tr>
                <td class="product-total">
                    <strong>Sub Total</strong>
                </td>
                <td class="product-total">
                    <strong>{{ isset($item->total) ? Helper::createRupiah($item->total) : '' }}</strong>
                </td>
            </tr>
            <tr class="summary-subtotal">
                <td>
                    <select class="form-control cou">
                        <option value="">Select Courier Provider</option>
                        @if(!empty($data_courier))
                        @foreach($data_courier as $cou)
                        <option value="{{ $cou->rajaongkir_courier_code }}">
                            {{ $cou->rajaongkir_courier_name }}</option>
                        @endforeach
                        @endif
                    </select>
                </td>
                <td></td>
            </tr>
            <tr class="summary-subtotal">
                <td>
                    <select id="service" class="form-control mt-3">
                        @if(isset($data_shipping))
                        @foreach($data_shipping as $shipping)
                        <option value="{{ $shipping['courier_price'] }}">
                            {{ strtoupper($shipping['courier_code']).' '.$shipping['courier_service'].' '.$shipping['courier_mask'] }}
                        </option>
                        @endforeach
                        @else
                        <option value="">Courier Service</option>
                        @endif
                    </select>
                </td>
                <td class="summary-subtotal-price">{{ $cart->sum('total') }}</td>
            </tr>

            <tr>
                <td>
                    <h4 class="summary-subtitle"><strong>TOTAL</strong></h4>
                </td>
                <td>
                    <p class="summary-total-price">{{ Helper::createRupiah($cart->sum('total')) }}</p>
                </td>
            </tr>
        </tbody>
    </table>

</div>

@push('javascript')
<script>
$('.cou').change(function() {
    var kurir = $(".cou option:selected").val();
    var weight = 750;
    var from = '232';
    var to = '455';
    var service = $("#service");

    if (weight == '') {
        new PNotify({
            title: 'Weight is Empty !',
            text: 'Please Input correct Weight !',
            addclass: 'notification-danger',
            icon: 'fa fa-bolt'
        });
    } else {
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route("ongkir") }}',
            data: {
                from: from,
                to: to,
                weight: weight,
                courier: kurir
            },
            dataType: 'JSON',
            success: function(data) {
                service.empty();
                service.append('<option value="">Please Select service</option>');
                $.each(data, function(key, val) {
                    service.append('<option value="' + val.id + '">' + val.text +
                        '</option>');
                })
            }
        });

    }
});
</script>
@endpush