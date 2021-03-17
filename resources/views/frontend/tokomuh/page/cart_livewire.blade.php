<div class="container mb-2">
    <div class="row gutter-lg">

        @if(!Cart::isEmpty())
        <div class="col-lg-8 col-md-8">
            <table class="shop-table cart-table mt-2">
                <tbody>

                    @php

                    $grouped = Cart::getContent()->mapToGroups(function ($item, $key) {
                    $attributes = $item->attributes;
                    $data = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->getPriceSum(),
                    ];

                    $data = array_merge($data, $attributes->toArray());
                    return [$attributes['branch_id'] => (object)$data];
                    });

                    @endphp

                    @foreach($grouped->sort() as $branch)

                    <thead>
                        <tr>
                            <td class="text-left" colspan="5">
                                <div>
                                    <span class="text-md">{{ $branch[0]->branch_name }}</span>
                                    <br>
                                    <span>
                                        {{ Helper::getSingleProvince($branch[0]->branch_province) }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><span>Product</span></th>
                            <th class="text-center"><span>Price</span></th>
                            <th class="text-center"><span class="mr-3">Qty </span></th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    @foreach($branch as $cart)
                    <tr>
                        <td class="product-name">
                            <div class="row">
                                <div class="col-md-4 product-thumbnail">
                                    <figure>
                                        <a href="{{ route('product', ['slug' => $cart->product_slug]) }}">
                                            <img class="image-fluid"
                                                src="{{ Helper::files('product/'.$cart->product_image) }}" width="100"
                                                height="100" alt="product">
                                        </a>
                                        <a wire:click="actionDelete('{{ $cart->id }}')" class="product-remove"
                                            title="Remove this product">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </figure>
                                </div>
                                <div class="col-md-8">
                                    <div class="product-name-section">
                                        <a href="{{ route('product', ['slug' => $cart->product_slug]) }}">
                                            {{ $cart->name }}</a>
                                    </div>
                                    <div class="text-xs mb-2">
                                        @if(!empty($cart->color_name))
                                        <li class="">
                                            {{ $cart->color_name }}
                                        </li>
                                        @endif
                                        @if(!empty($cart->size_name))
                                        <li class="">
                                            {{ $cart->size_name }}
                                        </li>
                                        @endif
                                        @if(!empty($cart->variant_name))
                                        <li class="">
                                            {{ $cart->variant_name }}
                                        </li>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 area">
                                            <textarea data="{{ $cart->id }}" class="form-control" placeholder="catatan"
                                                rows="2">{{ $cart->notes }}</textarea>
                                        </div>
                                    </div>
                                    <span class="text-xs">
                                        weight : {{ $cart->product_weight }}gr
                                    </span>

                                </div>
                            </div>
                        </td>
                        <td class="product-subtotal text-center">
                            <span class="amount ml-3">{{ Helper::createRupiah($cart->price) }}</span>
                        </td>
                        <td class="product-quantity text-center">
                            <div class="input-group {{ $data_error == $cart->id ? 'error' : '' }}">
                                <button wire:click="actionMinus('{{ $cart->id }}')" class="d-icon-minus"></button>
                                <input class="form-control" wire:change="setQty('{{ $cart->id }}', $event.target.value)"
                                    value="{{ $cart->quantity }}" type="number">
                                <button wire:click="actionPlus('{{ $cart->id }}')" class="d-icon-plus"></button>
                            </div>
                            @if($data_error == $cart->id)
                            <span>stock kurang</span>
                            @endif
                        </td>
                        <td class="product-price">
                            <span class="amount">{{ number_format($cart->total) }}</span>
                        </td>
                    </tr>
                    @endforeach

                    @endforeach

                </tbody>

            </table>
        </div>
        <aside class="col-lg-4 sticky-sidebar-wrapper">
            <div class="sticky-sidebar" data-sticky-options="{'bottom': 20}">
                <div class="summary mb-4">
                    <div class="shipping-address pb-4">
                        <h4 class="summary-subtitle">Informasi Pengiriman</h4>
                        <input wire:model="name" type="text" class="form-control" placeholder="Nama" />
                        <textarea wire:model="address" class="form-control mb-2" rows="4"
                            placeholder="Alamat"></textarea>
                        <input wire:model="phone" type="text" class="form-control" placeholder="Handphone (628)" />
                        <input wire:model="email" type="text" class="form-control" placeholder="Email" />
                        <hr>
                        <div class="select-box">
                            <select wire:model="province" class="form-control">
                                <option value="">Select Province</option>
                                @foreach($data_province as $pro)
                                <option value="{{ $pro->rajaongkir_province_id }}">{{ $pro->rajaongkir_province_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="select-box">
                            <select wire:model="city" class="form-control">
                                <option value="">Select City</option>
                                @if(!empty($data_city))
                                @foreach($data_city as $cit)
                                <option value="{{ $cit->rajaongkir_city_id }}">{{ $cit->rajaongkir_city_type }}
                                    {{ $cit->rajaongkir_city_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="select-box">
                            <select wire:model="area" class="form-control">
                                <option value="">Select Area</option>
                                @if(!empty($data_area))
                                @foreach($data_area as $are)
                                <option value="{{ $are->rajaongkir_area_id }}">{{ $are->rajaongkir_area_name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <table class="shipping">
                        <tr class="summary-subtotal">
                            <td>
                                <h4 class="summary-subtitle">Sub Total</h4>
                            </td>
                            <td>
                                <p class="summary-subtotal-price">{{ number_format(Cart::getSubTotal()) }}</p>
                            </td>
                        </tr>
                    </table>
                    <table class="shipping">
                        <tr class="">
                            <td>
                                <input type="text" wire:model="coupon" class="input-text form-control"
                                    placeholder="Coupon code">
                            </td>
                            <td>
                                @if($coupon = Cart::getConditions()->first())
                                <button wire:click="removeCoupon" class="btn btn-dark">Remove</button>
                                @else
                                <button wire:click="updateCoupon" class="btn btn-dark">Apply</button>
                                @endif


                            </td>

                        </tr>
                        @if($errors->has($coupon))
                        <tr>
                            <td class="text-left">
                                Coupon not exists !
                            </td>
                        </tr>
                        @endif
                    </table>

                    <hr>

                    @if($coupon = Cart::getConditions()->first())
                    <table class="shipping">
                        <tr class="summary-subtotal">
                            <td>
                                <h4 class="summary-subtitle">{{ $coupon ? $coupon->getName() : 'No Voucher' }}</h4>
                            </td>
                            <td>
                                <p class="summary-subtotal-price">{{ $coupon ? number_format($coupon->getValue()) : 0 }}
                                </p>
                            </td>
                        </tr>
                    </table>
                    @endif

                    <table class="shipping" style="clear: both;">
                        <tr class="summary-subtotal">
                            <td>
                                <h4 class="summary-subtitle">Total</h4>
                            </td>
                            <td>
                                <p class="summary-total-price">{{ Helper::createRupiah(Cart::getTotal())}}</p>
                            </td>
                        </tr>
                    </table>
                    @if(session('area'))
                    <a href="{{ route('checkout') }}" class="btn btn-dark btn-checkout mb-5">Proceed to checkout</a>
                    @else
                    <a class="btn btn-dark btn-checkout mb-5">Please Complete Cart</a>
                    @endif
                </div>
            </div>
        </aside>
        @else
        <div class="col-md-12 col-lg-12">
            Belum ada Product
        </div>
        @endif
    </div>
</div>

@push('javascript')
<script>
document.addEventListener('livewire:load', function() {

    $(".area").on("change", function(e) {
        var notes = $(this).val();
        var product = $(this).attr('data');

        @this.live_product = product;
        @this.live_notes = notes;

    });
})
</script>
@endpush