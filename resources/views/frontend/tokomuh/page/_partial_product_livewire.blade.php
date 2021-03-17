<main class="main mt-4">
    <div class="page-content mb-10">
        <div class="container">
            <div class="product product-single row mb-4">
                <div class="col-md-6">
                    <div class="product-gallery pg-vertical">
                        <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1">
                            <figure class="product-image">
                                <img src="{{ Helper::files('product/thumbnail_'.$oproduct->item_product_image) }}"
                                    data-zoom-image="{{ Helper::files('product/'.$oproduct->item_product_image) }}"
                                    alt="{{ $oproduct->item_product_name }}" width="800" height="900">
                            </figure>
                            @foreach($images as $image)
                            <figure class="product-image">
                                <img src="{{ Helper::files('product_detail/thumbnail_'.$image->item_product_image_file) }}"
                                    data-zoom-image="{{ Helper::files('product_detail/'.$image->item_product_image_file) }}"
                                    alt="Women's Brown Leather Backpacks" width="800" height="900">
                            </figure>
                            @endforeach
                        </div>
                        <div class="product-thumbs-wrap">
                            <div class="product-thumbs">
                                <div class="product-thumb active">
                                    <img src="{{ Helper::files('product/thumbnail_'.$oproduct->item_product_image) }}"
                                        alt="{{ $oproduct->item_product_name }}" width="109" height="122">
                                </div>
                                @foreach($images as $image)
                                <div class="product-thumb">
                                    <img src="{{ Helper::files('product_detail/thumbnail_'.$image->item_product_image_file) }}"
                                        alt="product thumbnail" width="109" height="122">
                                </div>
                                @endforeach

                            </div>
                            <button class="thumb-up disabled"><i class="fas fa-chevron-left"></i></button>
                            <button class="thumb-down disabled"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-details">

                        <h1 class="product-name">{{ $oproduct->item_product_name }}</h1>
                        <div class="product-meta">
                            SKU : <span class="product-sku">{{ $oproduct->item_product_sku ?? 'Default' }}</span>
                            BRAND : <span
                                class="product-brand">{{ Str::upper($oproduct->item_brand_name ?? 'No Brand') }}</span>
                        </div>
                        <div class="product-price">Rp{{ Helper::createRupiah($oproduct->item_product_price) }}</div>

                        <p class="product-short-desc">
                            {!! $oproduct->item_product_description !!}
                        </p>
                        @auth
                        <a wire:click="actionLove('{{ $oproduct->item_product_id }}')" class="size-guide"><i class="fa fas fa-heart mr-2 button-love {{ $love ? 'love' : '' }}"></i>Wishlist</a>
                        @endauth
                        <hr class="product-divider">
                        <div class="product-form product-variations product-color">
                            <label>Color:</label>
                            <div class="select-box">
                                <select name="color" class="form-control">
                                    <option value="" selected="selected">Choose an Option</option>
                                    <option value="white">White</option>
                                    <option value="black">Black</option>
                                    <option value="brown">Brown</option>
                                    <option value="red">Red</option>
                                    <option value="green">Green</option>
                                    <option value="yellow">Yellow</option>
                                </select>
                            </div>
                        </div>
                        <div class="product-form product-variations product-size">
                            <label>Size:</label>
                            <div class="product-form-group">
                                <div class="select-box">
                                    <select name="size" class="form-control">
                                        <option value="" selected="selected">Choose an Option</option>
                                        <option value="s">Small</option>
                                        <option value="m">Medium</option>
                                        <option value="l">Large</option>
                                        <option value="xl">Extra Large</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="product-variation-price">
                            <span>$239.00</span>
                        </div>

                        <hr class="product-divider">

                        <div class="product-form product-qty">
                            <label>QTY:</label>
                            <div class="product-form-group">
                                <div class="input-group">
                                    <button class="quantity-minus d-icon-minus"></button>
                                    <input class="quantity form-control" type="number" min="1" max="1000000">
                                    <button class="quantity-plus d-icon-plus"></button>
                                </div>
                                <button class="btn-product btn-cart">
                                    <i class="d-icon-bag"></i>Add To Cart
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="tab tab-nav-simple product-tabs mb-4">
                <ul class="nav nav-tabs" role="tablist">
                    @if($oproduct->item_product_page_active_1)
                    <li class="nav-item">
                        <a class="nav-link active" href="#product-tab-1">{{ $oproduct->item_product_page_name_1 }}</a>
                    </li>
                    @endif
                    @if($oproduct->item_product_page_active_2)
                    <li class="nav-item">
                        <a class="nav-link" href="#product-tab-2">{{ $oproduct->item_product_page_name_2 }}</a>
                    </li>
                    @endif
                    @if($oproduct->item_product_page_active_3)
                    <li class="nav-item">
                        <a class="nav-link" href="#product-tab-3">{{ $oproduct->item_product_page_name_3 }}</a>
                    </li>
                    @endif
                </ul>
                <div class="tab-content">
                    @if($oproduct->item_product_page_active_1)
                    <div class="tab-pane active in" id="product-tab-1">
                        {!! $oproduct->item_product_page_content_1 !!}
                    </div>
                    @endif
                    @if($oproduct->item_product_page_active_2)
                    <div class="tab-pane" id="product-tab-2">
                        {!! $oproduct->item_product_page_content_2 !!}
                    </div>
                    @endif
                    @if($oproduct->item_product_page_active_3)
                    <div class="tab-pane" id="product-tab-3">
                        {!! $oproduct->item_product_page_content_3 !!}
                    </div>
                    @endif
                </div>
            </div>

            <section>
                <h2 class="title">Our Featured</h2>

                <div class="owl-carousel owl-theme owl-nav-full row cols-2 cols-md-3 cols-lg-4" data-owl-options="{
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
									'items': 4,
									'dots': false,
									'nav': true
								}
							}
						}">
                    <div class="product shadow-media">
                        <figure class="product-media">
                            <a href="product.html">
                                <img src="{{ Helper::frontend('images/product/featured1.jpg') }}" alt="product"
                                    width="280" height="315">
                            </a>
                            <div class="product-label-group">
                                <label class="product-label label-new">new</label>
                            </div>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                    data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            </div>
                            <div class="product-action">
                                <a href="#" class="btn-product btn-quickview" title="Quick View">Quick View</a>
                            </div>
                        </figure>
                        <div class="product-details">
                            <a href="#" class="btn-wishlist" title="Add to wishlist"><i class="d-icon-heart"></i></a>
                            <div class="product-cat">
                                <a href="shop-grid-3col.html">categories</a>
                            </div>
                            <h3 class="product-name">
                                <a href="product.html">Women's Fashion Summer Dress</a>
                            </h3>
                            <div class="product-price">
                                <ins class="new-price">$199.00</ins><del class="old-price">$210.00</del>
                            </div>
                            <div class="ratings-container">
                                <div class="ratings-full">
                                    <span class="ratings" style="width:100%"></span>
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <a href="#" class="rating-reviews">( <span class="review-count">6</span> reviews
                                    )</a>
                            </div>
                        </div>
                    </div>
                    <div class="product shadow-media">
                        <figure class="product-media">
                            <a href="product.html">
                                <img src="{{ Helper::frontend('images/product/featured2.jpg') }}" alt="product"
                                    width="280" height="315">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                    data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            </div>
                            <div class="product-action">
                                <a href="#" class="btn-product btn-quickview" title="Quick View">Quick View</a>
                            </div>
                        </figure>
                        <div class="product-details">
                            <a href="#" class="btn-wishlist" title="Add to wishlist"><i class="d-icon-heart"></i></a>
                            <div class="product-cat">
                                <a href="shop-grid-3col.html">categories</a>
                            </div>
                            <h3 class="product-name">
                                <a href="product.html">Mackintosh Poket Backpack</a>
                            </h3>
                            <div class="product-price">
                                <span class="price">$35.00</span>
                            </div>
                            <div class="ratings-container">
                                <div class="ratings-full">
                                    <span class="ratings" style="width:100%"></span>
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <a href="#" class="rating-reviews">( <span class="review-count">6</span> reviews
                                    )</a>
                            </div>
                        </div>
                    </div>
                    <div class="product shadow-media">
                        <figure class="product-media">
                            <a href="product.html">
                                <img src="{{ Helper::frontend('images/product/featured3.jpg') }}" alt="product"
                                    width="280" height="315">
                            </a>

                            <div class="product-label-group">
                                <label class="product-label label-sale">27% off</label>
                            </div>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                    data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            </div>
                            <div class="product-action">
                                <a href="#" class="btn-product btn-quickview" title="Quick View">Quick View</a>
                            </div>
                        </figure>
                        <div class="product-details">
                            <a href="#" class="btn-wishlist" title="Add to wishlist"><i class="d-icon-heart"></i></a>
                            <div class="product-cat">
                                <a href="shop-grid-3col.html">categories</a>
                            </div>
                            <h3 class="product-name">
                                <a href="product.html">Women's Fashion T Shirt</a>
                            </h3>
                            <div class="product-price">
                                <span class="price">$19.00</span>
                            </div>
                            <div class="ratings-container">
                                <div class="ratings-full">
                                    <span class="ratings" style="width:100%"></span>
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <a href="#" class="rating-reviews">( <span class="review-count">6</span> reviews
                                    )</a>
                            </div>
                        </div>
                    </div>
                    <div class="product shadow-media">
                        <figure class="product-media">
                            <a href="product.html">
                                <img src="{{ Helper::frontend('images/product/featured4.jpg') }}" alt="product"
                                    width="280" height="315">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                    data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                            </div>
                            <div class="product-action">
                                <a href="#" class="btn-product btn-quickview" title="Quick View">Quick View</a>
                            </div>
                        </figure>
                        <div class="product-details">
                            <a href="#" class="btn-wishlist" title="Add to wishlist"><i class="d-icon-heart"></i></a>
                            <div class="product-cat">
                                <a href="shop-grid-3col.html">categories</a>
                            </div>
                            <h3 class="product-name">
                                <a href="product.html">Fashion Training Sneaker</a>
                            </h3>
                            <div class="product-price">
                                <ins class="new-price">$98.00</ins><del class="old-price">$210.00</del>
                            </div>
                            <div class="ratings-container">
                                <div class="ratings-full">
                                    <span class="ratings" style="width:100%"></span>
                                    <span class="tooltiptext tooltip-top"></span>
                                </div>
                                <a href="#" class="rating-reviews">( <span class="review-count">6</span> reviews
                                    )</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>