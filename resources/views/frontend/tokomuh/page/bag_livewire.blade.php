<div class="dropdown cart-dropdown">
    <a href="" class="cart-toggle">
        <i class="minicart-icon">
            <span class="cart-count">{{ Cart::getTotalQuantity() }}</span>
        </i>
    </a>
    <!-- End of Cart Toggle -->
    <div class="dropdown-box">
        <div class="product product-cart-header">
            <span class="product-cart-counts">{{ Cart::getTotalQuantity() }} items</span>
            <span><a href="{{ route('cart') }}">View cart</a></span>
        </div>
        <div class="products scrollable">
            @if(!Cart::isEmpty())
            @foreach(Cart::getContent() as $cart)
            @php
            $item = $cart->attributes ?? null;
            $product_slug = $item['product_slug'] ?? null;
            $product_image = $item['product_image'] ?? null;
            $color_name = $item['color_name'] ?? null;
            $size_name = $item['size_name'] ?? null;
            $variant_name = $item['variant_name'] ?? null;
            @endphp
            <div class="product product-cart">
                <div class="product-detail">
                    <a href="{{ route('product', ['slug' => $product_slug]) }}" class="product-name">
                        {{ $cart->name }}
                    </a>
                    <div class="price-box mb-2" style="margin-top: -15px;">
                        <ul>
                        @if(!empty($color_name))
                        <li class="mb-1">
                            {{ $color_name }}
                        </li>
                        @endif
                        @if(!empty($size_name))
                        <li class="mb-1">
                            {{ $size_name }}
                        </li>
                        @endif
                        @if(!empty($variant_name))
                        <li class="mb-1">
                            {{ $variant_name }}
                        </li>
                        @endif
                        </ul>
                    </div>
                    <div class="price-box" style="margin-top: -15px;">
                        <span class="product-quantity">{{ $cart->quantity }}</span>
                        <span class="product-price">{{ Helper::createRupiah($cart->price) }}</span>
                    </div>
                </div>
                <figure class="product-media">
                    <a href="{{ route('product', ['slug' => $product_slug]) }}">
                        <img src="{{ Helper::files('product/'.$product_image) }}" alt="{{ $cart->name }}" width="90"
                            height="90" />
                    </a>
                    <button wire:click="actionDelete('{{ $cart->id }}')" class="btn btn-link btn-close">
                        <i class="fas fa-times"></i>
                    </button>
                </figure>
            </div>
            <hr>
            @endforeach
            @endif
            <!-- End of Cart Product -->
        </div>
        <!-- End of Products  -->
        <div class="cart-total">
            <label>Sub Total:</label>
            <span class="price">{{ Helper::createRupiah(Cart::getSubTotal()) }}</span>
        </div>
        @if($coupon = Cart::getConditions()->first())
        <div class="cart-total">
            <label>Coupon {{ $coupon ? $coupon->getName() : 'No Voucher' }}:</label>
            <span class="price">{{ $coupon ? number_format($coupon->getValue()) : 0 }}</span>
        </div>
        <div class="cart-total">
            <label>Grand Total :</label>
            <span class="price">{{ number_format(Cart::getTotal()) }}</span>
        </div>
        @endif
        <!-- End of Cart Total -->
        @if(session('area'))
        <div class="cart-action mt-3">
            <a href="{{ route('checkout') }}" class="btn btn-dark"><span>Checkout</span></a>
        </div>
        @else
        <div class="cart-action mt-3">
            <a href="{{ route('cart') }}" class="btn btn-dark"><span>Complete Cart</span></a>
        </div>
        @endif

        <!-- End of Cart Action -->
    </div>
    <!-- End of Dropdown Box -->
</div>