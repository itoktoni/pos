<div class="row main-content-wrap gutter-lg">
    <aside class="col-lg-3 sidebar sidebar-fixed sidebar-toggle-remain shop-sidebar sticky-sidebar-wrapper">
        <div class="sidebar-overlay">
            <a class="sidebar-close" href="#"><i class="d-icon-times"></i></a>
        </div>
        <div class="sidebar-content">
            <div class="sticky-sidebar" data-sticky-options="{'top': 10}">
                <div class="filter-actions">
                    <a href="#" class="sidebar-toggle-btn toggle-remain btn btn-sm btn-outline btn-primary">Filters<i
                            class="d-icon-arrow-left"></i></a>
                    <a wire:click="actionClean()" class="filter-clean text-primary category-filter">Clean All</a>
                </div>
                <div class="widget widget-collapsible">
                    <h3 class="widget-title">All Categories</h3>
                    <ul class="widget-body filter-items search-ul">
                        @foreach($data_category as $category)
                        <li>
                            <a class="category-filter {{ array_key_exists($category->item_category_id, $session_category) ? 'active' : '' }}"
                                wire:click="actionCategory('{{ $category->item_category_id }}')">
                                {{ $category->item_category_name }}
                            </a>
                        </li>
                        @endforeach
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
                        <li><a href="#">Black</span></a></li>
                        <li><a href="#">Blue</a></li>
                        <li><a href="#">Green</a></li>
                    </ul>
                </div>
                <div class="widget widget-collapsible">
                    <h3 class="widget-title">Brands</h3>
                    <ul class="widget-body filter-items">
                        <li><a href="#">Black</a></li>
                        <li><a href="#">Blue</a></li>
                        <li><a href="#">Green</a></li>
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
                    <h3 class="widget-title">Tags</h3>
                    <div class="widget-body pt-2">
                        @foreach($data_tag as $key => $value)
                        <button class="btn tag {{ array_key_exists($key, $session_tag) ? 'active' : '' }}"
                            wire:click="actionTag('{{ $key }}', '{{ $value }}')">{{ $value }}
                        </button>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </aside>
    <div class="col-lg-9 main-content">
        <nav class="toolbox sticky-toolbox sticky-content fix-top">
            <div class="toolbox-left">
                <a href="#" class="toolbox-item left-sidebar-toggle btn btn-sm btn-outline btn-primary d-lg-none">
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
            @foreach($data_product as $product)
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
                                <button
                                    class="btn-product-icon btn-cart {{ array_key_exists($product->item_product_id, $data_wishlist) ? 'love' : '' }}"
                                    wire:click="actionWishlist('{{ $product->item_product_id }}')">
                                    <i class="fa fas fa-heart"></i>
                                </button>
                            </div>
                            @endauth
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
                            <ins class="new-price">Rp.{{ Helper::createRupiah($product->item_product_price) }}</ins>
                            {!! $product->item_product_stroke > 0 ? '<del class="old-price">
                                '.Helper::createRupiah($product->item_product_stroke).'</del>' : '' !!}
                        </div>

                    </div>
                </div>
            </div>
            @endforeach

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