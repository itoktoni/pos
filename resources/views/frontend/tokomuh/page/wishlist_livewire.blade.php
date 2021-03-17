<div class="page-content mb-10">
    <div class="container">
        <div class="main-content">
            <div class="row">
                <div class="col-md-7"></div>
                <div class="header-search mb-5 mt-5 col-md-5">
                    <div class="input-wrapper">
                        <input type="text" class="form-control" wire:model.debounce.500ms="search" value="{{ $search }}"
                            id="search" placeholder="Search your keyword...">
                        <button class="btn btn-sm btn-search" type="submit"><i class="d-icon-search"></i></button>
                    </div>
                </div>
            </div>

            <div class="row cols-2 cols-sm-3 cols-md-4 cols-xl-5 product-wrapper">
                @foreach($data_wishlist as $product)
                <div class="product-wrap">
                    <div class="product shadow-media">
                        <figure class="product-media">
                            <a href="{{ route('product', ['slug' => $product->item_product_slug]) }}">
                                <img src="{{ Helper::files('product/'.$product->item_product_image) }}"
                                    alt="{{ $product->item_product_name }}" width="280" height="315">
                            </a>
                            @if(!empty($product->item_product_flag_name))
                            <div class="product-label-group">
                                <label class="product-label label-new"
                                    style="background-color: #{{ $product->item_product_flag_background ?? '000' }};color:#{{ $product->item_product_flag_color ?? 'FFF' }}">{{ $product->item_product_flag_name }}</label>
                            </div>
                            @endif
                            <div class="product-action-vertical">
                                @auth
                                <div>
                                    <button class="btn-product-icon btn-cart love"
                                        wire:click="removeWishlist('{{ $product->item_product_id }}')">
                                        <i class="fa fas fa-heart"></i>
                                    </button>
                                </div>
                                @endauth
                            </div>
                        </figure>
                        <div class="product-details">
                            <div class="product-cat">
                                <a class="pointer"
                                    href="{{ route('category',['slug' => $product->item_category_slug]) }}">{{ $product->item_category_name }}</a>
                            </div>
                            <h3 class="product-name">
                                <a
                                    href="{{ route('product', ['slug' => $product->item_product_slug]) }}">{{ $product->item_product_name }}</a>
                            </h3>
                            <div class="product-price">
                                <ins class="new-price">Rp.{{ Helper::createRupiah($product->item_product_price) }}</ins>
                                {!! $product->item_product_stroke > 0 ? '<del class="old-price">
                                    '.Helper::createRupiah($product->item_product_stroke).'</del>' : '' !!}
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            {{ $data_wishlist->onEachSide(1)->links() }}
        </div>
    </div>
</div>