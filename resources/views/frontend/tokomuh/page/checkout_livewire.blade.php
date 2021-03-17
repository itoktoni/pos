<div class="container">
    <div class="form">
        <div class="row gutter-lg">
            @if($completed)
            <div class="container" style="margin-top: -100px;">

                <div class="main order">
                    <div class="page-content">

                        <div class="order-message mb-5">
                            <i class="fas fa-check"></i>Thank you, Your order has been created.
                        </div>

                        <div class="order-results ">
                            <div class="overview-item">
                                <span>Order number</span>
                                <strong>{{ $order_id }}</strong>
                            </div>
                            <div class="overview-item">
                                <span>Status</span>
                                <strong>Processing</strong>
                            </div>
                            <div class="overview-item">
                                <span>Date</span>
                                <strong>{{ date('d M Y') }}</strong>
                            </div>
                            <div class="overview-item">
                                <span>Ongkir</span>
                                <strong>{{ Helper::createRupiah($order_ongkir) }}</strong>
                            </div>
                            <div class="overview-item">
                                <span>Total</span>
                                <strong>{{ Helper::createRupiah($order_total) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @else
            @if(session()->get('checkout')->count() > 0)

            <h3 class="title title-default text-left">Checkout Detail</h3>
            <div class="col-lg-7 mb-6">
                <div class="sticky-sidebar">

                    @foreach(session('checkout') as $cart)
                    <div
                        class="summary mb-6 {{ $errors->has('checkout.'.$cart->branch_id.'.branch_ongkir') ? 'error' : '' }}">
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th colspan="1" class="text-left">{{ $cart->branch_name ?? '' }}</th>
                                    <th>{{ Helper::getSinglecity($cart->branch_city) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->branch_item as $item)
                                <tr>
                                    <td class="product-detail">
                                        <span>{{ $item->product_name ?? '' }}</span>
                                        <strong class="product-quantity">×&nbsp;{{ $item->qty ?? '' }}</strong>
                                        <br>
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
                                    <td class="product-total">
                                        {{ isset($item->total) ? Helper::createRupiah($item->total) : '' }}
                                        <br>

                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td class="product-total">
                                        <strong>Sub Total </strong>
                                        <span class="text-grey text-xs">
                                            with weight: {{ round($cart->branch_weight/1000,2) ?? '' }}Kg
                                        </span>
                                    </td>
                                    <td class="product-total">
                                        <strong>{{ Helper::createRupiah($cart->branch_subtotal) }}</strong>
                                    </td>
                                </tr>
                                <tr class="summary-subtotal">
                                    <td>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr class="summary-subtotal">
                                    <td>
                                        @if(session()->has('area'))
                                        <select class="mt-3 form-control courier">
                                            <option value="">Select Courier Provider</option>
                                            @if(!empty($data_courier))
                                            @foreach($data_courier as $courier)
                                            <option
                                                {{ isset($cart->branch_courier) && $cart->branch_courier['code'] == strtoupper($courier->rajaongkir_courier_code) ? 'selected' : '' }}
                                                value="{{ $courier->rajaongkir_courier_code }}">
                                                {{ $courier->rajaongkir_courier_name }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <input type="hidden" class="from" value="{{ $cart->branch_area }}">
                                        <input type="hidden" class="to" value="{{ session('area') }}">
                                        <input type="hidden" class="branch" value="{{ $cart->branch_id }}">
                                        <input type="hidden" class="weight" value="{{ $cart->branch_weight }}">

                                        @endif
                                    </td>

                                    <td class="summary-subtotal-price"><span class="price"></td>
                                </tr>

                                <tr>
                                    <td>
                                        <select class="service form-control mt-3">
                                            @if(isset($cart->branch_ongkir))
                                            <option selected value="{{ $cart->branch_courier['price'] }}">
                                                {{ $cart->branch_courier['code'] }}
                                                ({{ $cart->branch_courier['service'] }})
                                                Harga : {{ Helper::createRupiah($cart->branch_ongkir)  }}
                                            </option>
                                            @else
                                            <option value="">Select Service</option>
                                            @endif
                                        </select>
                                    </td>
                                    <td class="summary-subtotal-price text-grey">
                                        {{ Helper::createRupiah($cart->branch_ongkir ?? 0) }}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <h4 class="summary-subtitle"><strong>TOTAL</strong></h4>
                                    </td>
                                    <td>
                                        <p class="summary-total-price">
                                            @if(isset($price[$cart->branch_id]))
                                            {{ Helper::createRupiah($cart->branch_total - $price[$cart->branch_id]['price']) }}
                                            @else
                                            {{ Helper::createRupiah($cart->branch_total) }}
                                            @endisset
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    @endforeach
                </div>
            </div>
            <aside class="col-lg-5 sticky-sidebar-wrapper">
                <div class="sticky-sidebar">
                    <div class="summary">

                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>Alamat Pengiriman</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>

                        <section class="summary-information">
                            <h2 class="title title-simple text-left">{{ session('name') ?? '' }}</h2>
                            @if(session()->has('address'))
                            <p class="text-grey">{{ session('address') ?? '' }}</p>
                            @endif
                            @if(session()->has('area'))
                            <p class="text-grey">
                                {{ !empty(session('area')) ? Helper::getSingleArea(session('area'), true) : '' }}
                            </p>
                            @endif
                            @if(session()->has('phone'))
                            <p class="text-grey">{{ session('phone') ?? '' }}</p>
                            @endif
                            @if(session()->has('email'))
                            <p class="text-grey">{{ session('email') ?? '' }}</p>
                            @endif
                            <textarea wire:model.lazy="notes" class="form-control mb-2 mt-3" rows="3"
                                placeholder="Notes"></textarea>
                        </section>

                        <table class="order-table mt-5">
                            <thead>
                                <tr>
                                    <th>Summary Order</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="product-total">
                                        <strong>Sub Total</strong>
                                    </td>
                                    <td class="product-total">
                                        <strong>{{ Helper::createRupiah(Cart::getSubTotal()) }}</strong>
                                    </td>
                                </tr>
                                @if($coupon = Cart::getConditions()->first())
                                <tr>
                                    <td class="product-total">
                                        <strong>Coupon {{ $coupon ? $coupon->getName() : 'No Voucher' }}</strong>
                                    </td>
                                    <td class="product-total">
                                        <strong>{{ $coupon ? number_format($coupon->getValue()) : 0 }}</strong>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="product-total">
                                        <strong>Total Ongkir</strong>
                                    </td>
                                    <td class="product-total">
                                        <strong>{{ Helper::createRupiah($ongkir) }}</strong>
                                    </td>
                                </tr>
                                <tr class="summary-subtotal">
                                    <td>
                                        <h4 class="summary-subtitle"><strong>TOTAL</strong></h4>
                                    </td>
                                    <td>
                                        <p class="summary-total-price">
                                            {{ number_format(Cart::getTotal() + $ongkir) }}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="payment accordion radio-type">
                            <h4 class="summary-subtitle">Payment Methods</h4>
                            @foreach($data_bank as $bank)
                            <div class="card">
                                <div class="card-header">
                                    <a href="#data{{ $bank->finance_bank_id }}"
                                        class="{{ $loop->first ? 'collapse' : 'expand' }}">
                                        {{ $bank->finance_bank_name }} - {{ $bank->finance_bank_account_name }}
                                        ({{ $bank->finance_bank_account_number }})
                                    </a>
                                </div>
                                <div id="data{{ $bank->finance_bank_id }}"
                                    class="{{ $loop->first ? 'expanded' : 'collapsed' }}"
                                    style="display: {{ $loop->first ? 'block' : '' }};">
                                    <div class="card-body">
                                        {{ $bank->finance_bank_description }}
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>

                        <p class="checkout-info">Your personal data will used to process your order, support
                            your experience throughout this website, and for other purposes described in our
                            privacy policy.</p>

                        <button wire:click="createOrder" class="btn btn-dark btn-order mb-5">
                            Create Order
                        </button>
                    </div>
                </div>

                @if($errors->any())
                <div class="alert text-default mt-5">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

            </aside>
            @else
            <div class="order-message text-md">
                <i class="fas fa-check"></i> Please Buy some product !.
            </div>
            @endif
            @endif
        </div>
    </div>
</div>


@push('javascript')
<script>
document.addEventListener('livewire:load', function() {

    $('.courier').change(function() {

        var service = $('.service');

        var kurir = $(this).val();
        var weight = $(this).siblings('.weight').val();
        var from = $(this).siblings('.from').val();
        var to = $(this).siblings('.to').val();
        var branch = $(this).siblings('.branch').val();

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
                    branch: branch,
                    weight: weight,
                    from: from,
                    to: to,
                    courier: kurir
                },
                dataType: 'JSON',
                success: function(data) {

                    console.log(data);

                    if (data.length > 0) {
                        service.empty();
                        service.append('<option value="">Please Select service</option>');
                        $.each(data, function(key, val) {
                            service.append('<option branch="' + val.branch +
                                '" weight="' + val.weight + '" code="' + val
                                .courier_code + '" service="' + val
                                .courier_service + '" value="' + val
                                .courier_price + '">' + val.courier_code +
                                ' (' + val.courier_service + ') Harga : ' + val
                                .courier_mask + '</option>');
                        });
                    } else {
                        service.empty();
                        service.append('<option value="">Service Not Available</option>');
                    }

                }
            });

        }
    });

    $(".service").on("change", function(e) {
        var option = $('option:selected', this);
        var dbranch = option.attr('branch');
        var dweight = option.attr('weight');
        var dcode = option.attr('code');
        var dservice = option.attr('service');
        var dprice = option.val();

        var data = {
            "branch": dbranch,
            "weight": dweight,
            "code": dcode,
            "service": dservice,
            "price": dprice
        };

        if (dbranch) {
            Livewire.emit('setOngkir', data)
        }
    });
})
</script>
@endpush