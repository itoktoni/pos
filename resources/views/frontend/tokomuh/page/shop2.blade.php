@extends(Helper::setExtendFrontend())

@push('css')
<link rel="stylesheet" type="text/css" href="{{ Helper::frontend('vendor/nouislider/nouislider.min.css') }}">
@endpush

@push('js')
<script src="{{ Helper::frontend('vendor/nouislider/nouislider.min.js') }}"></script>
@endpush

@section('content')

<!-- End PageHeader -->
<div class="shopping page-content mb-10">
    <div class="container">
        <div class="row main-content-wrap gutter-lg">
            <aside class="col-lg-3 sidebar sidebar-fixed sidebar-toggle-remain shop-sidebar sticky-sidebar-wrapper">
                <div class="sidebar-overlay">
                    <a class="sidebar-close" href="#"><i class="d-icon-times"></i></a>
                </div>
                <div class="sidebar-content">
                    <div class="sticky-sidebar" data-sticky-options="{'top': 10}">
                        <div class="filter-actions">
                            <a href="#"
                                class="sidebar-toggle-btn toggle-remain btn btn-sm btn-outline btn-primary">Filters<i
                                    class="d-icon-arrow-left"></i></a>
                            <a href="#" class="filter-clean text-primary">Clean All</a>
                        </div>
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">All Categories</h3>
                            <ul class="widget-body filter-items search-ul">
                                <li><a href="#">Bags</a></li>
                                <li><a href="#">Sport Shorts</a></li>
                                <li class="with-ul show">
                                    <a href="#">Clothing</a>
                                    <ul style="display: block">
                                        <li><a href="#">Summer sale</a></li>
                                        <li><a href="#">Shirts</a></li>
                                        <li><a href="#">Trunks</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Shoes</a></li>
                                <li class="with-ul">
                                    <a href="#">Sweaters</a>
                                    <ul>
                                        <li><a href="#">T-Shirts</a></li>
                                        <li><a href="#">Dress</a></li>
                                        <li><a href="#">Blouse</a></li>
                                    </ul>
                                </li>
                                <li class="with-ul">
                                    <a href="#">Uncategorized</a>
                                    <ul>
                                        <li><a href="#">Trousers</a></li>
                                        <li><a href="#">Jacket</a></li>
                                        <li><a href="#">Caps</a></li>
                                    </ul>
                                </li>
                                <li class="with-ul">
                                    <a href="#">Women</a>
                                    <ul>
                                        <li><a href="#">Summer sales</a></li>
                                        <li><a href="#">Shirts</a></li>
                                        <li><a href="#">Trunks</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">Size</h3>

                            <ul class="widget-body filter-items">
                                <li><a href="#">Medium</a></li>
                                <li><a href="#">Large</a></li>
                                <li><a href="#">Extra Large</a></li>
                            </ul>
                        </div>
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">Color</h3>
                            <ul class="widget-body filter-items">
                                <li><a onclick="alert('test')" href="#">Black<span>(2)</span></a></li>
                                <li><a href="#">Blue<span>(1)</span></a></li>
                                <li><a href="#">Green<span>(9)</span></a></li>
                            </ul>
                        </div>
                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">Brands</h3>
                            <ul class="widget-body filter-items">
                                <li><a href="#">Black<span>(2)</span></a></li>
                                <li><a href="#">Blue<span>(1)</span></a></li>
                                <li><a href="#">Green<span>(9)</span></a></li>
                            </ul>
                        </div>

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">Location</h3>
                            <ul class="widget-body filter-items">
                                <li><a href="#">Small</a></li>
                                <li><a href="#">Medium</a></li>
                                <li><a href="#">Large</a></li>
                                <li><a href="#">Extra Large</a></li>
                            </ul>
                        </div>

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">Tag</h3>
                            <ul class="widget-body filter-items">
                                <li><a href="#">Small</a></li>
                                <li><a href="#">Medium</a></li>
                                <li><a href="#">Large</a></li>
                                <li><a href="#">Extra Large</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </aside>
            <div class="col-lg-9 main-content">
                <nav class="toolbox sticky-toolbox sticky-content fix-top">
                    <div class="toolbox-left">
                        <a href="#"
                            class="toolbox-item left-sidebar-toggle btn btn-sm btn-outline btn-primary d-lg-none">
                            Filters<i class="d-icon-arrow-right"></i>
                        </a>
                    </div>
                    <div class="toolbox-right">
                        <div class="toolbox-item toolbox-sort select-box">
                            <label>Sort By :</label>
                            <select name="orderby" class="form-control">
                                <option value="default">Default</option>
                                <option value="popularity" selected="selected">Most Popular</option>
                                <option value="rating">Average rating</option>
                                <option value="date">Latest</option>
                                <option value="price-low">Sort forward price low</option>
                                <option value="price-high">Sort forward price high</option>
                                <option value="">Clear custom sort</option>
                            </select>
                        </div>
                        <!-- <div class="toolbox-item toolbox-layout">
                            <a href="shop-list.html" class="d-icon-mode-list btn-layout"></a>
                            <a href="shop.html" class="d-icon-mode-grid btn-layout active"></a>
                        </div> -->
                    </div>
                </nav>
                <div class="row cols-2 cols-sm-3 product-wrapper">
                    @foreach($gproduct as $product)
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

                                    @livewire('cart.wishlist')
                                    
                                </div>
                                <!-- <div class="product-action">
                                    <a href="{{ route('view', ['slug' => $product->item_product_slug]) }}"
                                        class="btn-product btn-quickview" title="Quick View">
                                        Preview
                                    </a>
                                </div> -->
                            </figure>
                            <div class="product-details">
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">{{ $product->item_category_name }}</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">{{ $product->item_product_name }}</a>
                                </h3>
                                <div class="product-price">
                                    <ins class="new-price">Rp.
                                        {{ Helper::createRupiah($product->item_product_price) }}</ins><del
                                        class="old-price">{{ Helper::createRupiah($product->item_product_stroke) }}</del>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="product-wrap">
                        <div class="product shadow-media">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ Helper::frontend('images/shop/2.jpg') }}" alt="product" width="280"
                                        height="315">
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                        View</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <a href="#" class="btn-wishlist" title="Add to wishlist"><i
                                        class="d-icon-heart"></i></a>
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">categories</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">Fashionable Hooded Coat</a>
                                </h3>
                                <div class="product-price">
                                    <span class="price">$35.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="product shadow-media">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ Helper::frontend('images/shop/3.jpg') }}" alt="product" width="280"
                                        height="315">
                                </a>

                                <div class="product-label-group">
                                    <label class="product-label label-sale">27% off</label>
                                </div>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                        View</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <a href="#" class="btn-wishlist" title="Add to wishlist"><i
                                        class="d-icon-heart"></i></a>
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">categories</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">Women's Fashion Handbag</a>
                                </h3>
                                <div class="product-price">
                                    <span class="price">$19.00</span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="product shadow-media">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ Helper::frontend('images/shop/4.jpg') }}" alt="product" width="280"
                                        height="315">
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                        View</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <a href="#" class="btn-wishlist" title="Add to wishlist"><i
                                        class="d-icon-heart"></i></a>
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">categories</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">Fashionable Padded Jacket</a>
                                </h3>
                                <div class="product-price">
                                    <ins class="new-price">$98.00</ins><del class="old-price">$210.00</del>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="product shadow-media">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ Helper::frontend('images/shop/5.jpg') }}" alt="product" width="280"
                                        height="315">
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                        View</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <a href="#" class="btn-wishlist" title="Add to wishlist"><i
                                        class="d-icon-heart"></i></a>
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">categories</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">Cavin Fashion Suede Handbag</a>
                                </h3>
                                <div class="product-price">
                                    <ins class="new-price">$98.00</ins><del class="old-price">$210.00</del>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="product shadow-media">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ Helper::frontend('images/shop/6.jpg') }}" alt="product" width="280"
                                        height="315">
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                        View</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <a href="#" class="btn-wishlist" title="Add to wishlist"><i
                                        class="d-icon-heart"></i></a>
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">categories</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">Women's Fashion Hood</a>
                                </h3>
                                <div class="product-price">
                                    <ins class="new-price">$98.00</ins><del class="old-price">$210.00</del>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="product shadow-media">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ Helper::frontend('images/shop/7.jpg') }}" alt="product" width="280"
                                        height="315">
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                        View</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <a href="#" class="btn-wishlist" title="Add to wishlist"><i
                                        class="d-icon-heart"></i></a>
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">categories</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">Converse Blue Training Shoes</a>
                                </h3>
                                <div class="product-price">
                                    <ins class="new-price">$98.00</ins><del class="old-price">$210.00</del>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="product shadow-media">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ Helper::frontend('images/shop/8.jpg') }}" alt="product" width="280"
                                        height="315">
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                        View</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <a href="#" class="btn-wishlist" title="Add to wishlist"><i
                                        class="d-icon-heart"></i></a>
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">categories</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">Beyond OTP Jacket</a>
                                </h3>
                                <div class="product-price">
                                    <ins class="new-price">$98.00</ins><del class="old-price">$210.00</del>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="product shadow-media">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ Helper::frontend('images/shop/9.jpg') }}" alt="product" width="280"
                                        height="315">
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                        View</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <a href="#" class="btn-wishlist" title="Add to wishlist"><i
                                        class="d-icon-heart"></i></a>
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">categories</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">Fashion Overnight Bag</a>
                                </h3>
                                <div class="product-price">
                                    <ins class="new-price">$98.00</ins><del class="old-price">$210.00</del>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="product shadow-media">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ Helper::frontend('images/shop/10.jpg') }}" alt="product" width="280"
                                        height="315">
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                        View</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <a href="#" class="btn-wishlist" title="Add to wishlist"><i
                                        class="d-icon-heart"></i></a>
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">categories</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">Fashion Brown Suede Shoes</a>
                                </h3>
                                <div class="product-price">
                                    <ins class="new-price">$98.00</ins><del class="old-price">$210.00</del>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="product shadow-media">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ Helper::frontend('images/shop/11.jpg') }}" alt="product" width="280"
                                        height="315">
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                        View</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <a href="#" class="btn-wishlist" title="Add to wishlist"><i
                                        class="d-icon-heart"></i></a>
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">categories</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">Men's Fashion Jacket</a>
                                </h3>
                                <div class="product-price">
                                    <ins class="new-price">$98.00</ins><del class="old-price">$210.00</del>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="product shadow-media">
                            <figure class="product-media">
                                <a href="product.html">
                                    <img src="{{ Helper::frontend('images/shop/12.jpg') }}" alt="product" width="280"
                                        height="315">
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-quickview" title="Quick View">Quick
                                        View</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <a href="#" class="btn-wishlist" title="Add to wishlist"><i
                                        class="d-icon-heart"></i></a>
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">categories</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="product.html">Fashion Cowboy Hat</a>
                                </h3>
                                <div class="product-price">
                                    <ins class="new-price">$98.00</ins><del class="old-price">$210.00</del>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <nav class="toolbox toolbox-pagination">
                    <p class="show-info">Showing <span>12 of 56</span> Products</p>
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1"
                                aria-disabled="true">
                                <i class="d-icon-arrow-left"></i>Prev
                            </a>
                        </li>
                        <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item page-item-dots"><a class="page-link" href="#">6</a></li>
                        <li class="page-item">
                            <a class="page-link page-link-next" href="#" aria-label="Next">
                                Next<i class="d-icon-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

@endsection