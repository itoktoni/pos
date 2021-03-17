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
                <div class="widget">
                    <h3 wire:click="actionCategory('reset')" class="widget-title pointer">All Categories</h3>
                    <ul class="widget-body filter-items search-ul">
                        @foreach($data_category as $cat)
                        <li>
                            <a class="category-filter {{ $cat->item_category_slug == $murah ? 'active' : '' }}"
                                wire:click="actionCategory('{{ $cat->item_category_slug }}')">
                                {{ $cat->item_category_name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="widget">
                    <h3 class="widget-title pointer">All Size</h3>

                    <ul class="widget-body filter-items">
                        @foreach($data_size as $key => $value)
                        <li class="{{ array_key_exists($key, $session_size) ? 'active' : '' }}"
                            wire:click="actionSize('{{ $key }}')"><a>{{ $value }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="widget">
                    <h3 class="widget-title pointer">All Color</h3>
                    <ul class="widget-body filter-items">
                        @foreach($data_color as $ckey => $cvalue)
                        <li class="{{ array_key_exists('c'.$ckey, $session_color) ? 'active' : '' }}"
                            wire:click="actionColor('{{ $ckey }}')"><a>{{ $cvalue }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="widget">
                    <h3 class="widget-title pointer">All Brands</h3>
                    <ul class="widget-body filter-items">
                        @foreach($data_brand as $ckey => $cvalue)
                        <li class="{{ array_key_exists('c'.$ckey, $session_brand) ? 'active' : '' }}"
                            wire:click="actionBrand('{{ $ckey }}')"><a>{{ $cvalue }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="widget">
                    <h3 class="widget-title pointer">All Province</h3>
                    <ul class="widget-body filter-items">
                        @foreach($data_province as $ckey => $cvalue)
                        <li class="{{ array_key_exists('c'.$ckey, $session_province) ? 'active' : '' }}"
                            wire:click="actionProvince('{{ $ckey }}')"><a>{{ $cvalue }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="widget">
                    <h3 class="widget-title pointer">All Tags</h3>
                    <div class="widget-body pt-2">
                        @foreach($data_tag as $key => $value)
                        <button class="btn tag {{ array_key_exists($key, $session_tag) ? 'active' : '' }}"
                            wire:click="actionTag('{{ $key }}')">{{ $value }}
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
                    <select wire:model="sort" class="form-control">
                        <option value="">Default</option>
                        <option value="popular">Most Popular</option>
                        <option value="seller">Best Seller</option>
                        <option value="date">Latest Update</option>
                        <option value="low">Sort Low Price</option>
                        <option value="high">Sort High Price</option>
                    </select>
                </div>
                <!-- <div class="toolbox-item toolbox-layout">
                            <a href="shop-list.html" class="d-icon-mode-list btn-layout"></a>
                            <a href="shop.html" class="d-icon-mode-grid btn-layout active"></a>
                        </div> -->
            </div>
        </nav>

        <div class="header-search mb-5">
            <div class="input-wrapper">
                <input type="text" class="form-control" wire:model.debounce.500ms="search" value="{{ $search }}" id="search" placeholder="Search your keyword...">
                <button class="btn btn-sm btn-search" type="submit"><i class="d-icon-search"></i></button>
            </div>
        </div>

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
                            <a class="pointer" wire:click="actionCategory('{{ $product->item_category_slug }}')">{{ $product->item_category_name }}</a>
                        </div>
                        <h3 class="product-name">
                            <a href="{{ route('product', ['slug' => $product->item_product_slug]) }}">{{ $product->item_product_name }}</a>
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
        {{ $data_product->onEachSide(1)->links() }}
    </div>
</div>
</div>
</div>