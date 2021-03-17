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
                    <div class="price-box">
                        <span class="product-quantity">{{ $cart->quantity }}</span>
                        <span class="product-price">{{ Helper::createRupiah($cart->price) }}</span>
                    </div>
                </div>
                <figure class="product-media">
                    <a href="#">
                        <img src="{{ Helper::files('product/'.$product_image) }}" alt="product" width="90"
                            height="90" />
                    </a>
                    <button class="btn btn-link btn-close">
                        <i class="fas fa-times"></i>
                    </button>
                </figure>
            </div>
            @endforeach
            @endif

            <!-- End of Cart Product -->
        </div>
        <!-- End of Products  -->
        <div class="cart-total">
            <label>Subtotal:</label>
            <span class="price">{{ Helper::createRupiah(Cart::getTotal())}}</span>
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
        <div class="cart-action">
            <a href="{{ route('checkout') }}" class="btn btn-dark"><span>Checkout</span></a>
        </div>
        <!-- End of Cart Action -->
    </div>
    <!-- End of Dropdown Box -->
</div>