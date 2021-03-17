<section class="product-wrapper container appear-animate mt-10 pt-3 pb-8" data-animation-options="{
                    'delay': '.3s'
                }">
    <h2 class="title">New Product</h2>
    <div class="owl-carousel owl-theme row cols-2 cols-md-3 cols-lg-4 cols-xl-5" data-owl-options="{
                        'items': 5,
                        'nav': false,
                        'loop': false,
                        'dots': true,
                        'margin': 20,
                        'responsive': {
                            '0': {
                                'items': 2
                            },
                            '768': {
                                'items': 3
                            },
                            '992': {
                                'items': 4
                            },
                            '1200': {
                                'items': 5,
                                'dots': false,
                                'nav': true
                            }
                        }
                    }">
        @foreach($new_product as $new)

        <div class="product">
            <figure class="product-media">
                <a href="{{ route('product', ['slug' => $new->item_product_slug]) }}">
                    <img src="{{ Helper::files('product/'.$new->item_product_image) }}"
                        alt="Blue Pinafore Denim Dress" width="280" height="315">
                </a>

                @if(!empty($new->item_product_flag_name))
                <div class="product-label-group">
                    <label class="product-label label-new"
                        style="background-color: #{{ $new->item_product_flag_background ?? '000' }};color:#{{ $new->item_product_flag_color ?? 'FFF' }}">{{ $new->item_product_flag_name }}</label>
                </div>
                @endif

                @auth
                <div class="product-action-vertical">
                    @livewire('ecommerce.love-livewire', ['product_id' => $new->item_product_id])
                </div>
                @endauth

            </figure>
            <div class="product-details">
                <div class="product-cat">
                    <a href="{{ route('category', ['slug' => $new->item_category_slug]) }}">{{ $new->item_category_name }}</a>
                </div>
                <h3 class="product-name">
                    <a href="{{ route('product', ['slug' => $new->item_product_slug]) }}">{{ $new->item_product_name }}</a>
                </h3>
                <div class="product-price">
                    <ins class="new-price">Rp.{{ Helper::createRupiah($new->item_product_price) }}</ins>
                    {!! $new->item_product_stroke > 0 ? '<del class="old-price">
                        '.Helper::createRupiah($new->item_product_stroke).'</del>' : '' !!}
                </div>
            </div>
        </div>

        @endforeach

    </div>
</section>