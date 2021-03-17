<nav class="main-nav">
    <ul class="menu">
        <li class="active">
            <a href="{{ url('/') }}">Home</a>
        </li>
        <li>
            <a href="{{ route('shop') }}">Shop</a>
        </li>
        
        <!-- <li>
            <a href="shop.html">Categories</a>
            <div class="megamenu">
                <div class="row">
                    <div class="col-6 col-sm-4 col-md-3 col-lg-4">
                        <h4 class="menu-title">Variations 1</h4>
                        <ul>
                            <li><a href="shop-banner-sidebar.html">Banner With Sidebar</a></li>
                            <li><a href="shop-boxed-banner.html">Boxed Banner</a></li>
                            <li><a href="shop-infinite-scroll.html">Infinite Ajaxscroll</a></li>
                            <li><a href="shop-horizontal-filter.html">Horizontal Filter</a>
                            </li>
                            <li><a href="shop-navigation-filter.html">Navigation Filter<span
                                        class="tip tip-hot">Hot</span></a></li>

                            <li><a href="shop-off-canvas.html">Off-Canvas Filter</a></li>
                            <li><a href="shop-right-sidebar.html">Right Toggle Sidebar</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-4">
                        <h4 class="menu-title">Variations 2</h4>
                        <ul>

                            <li><a href="shop-grid-3cols.html">3 Columns Mode<span class="tip tip-new">New</span></a>
                            </li>
                            <li><a href="shop-grid-4cols.html">4 Columns Mode</a></li>
                            <li><a href="shop-grid-5cols.html">5 Columns Mode</a></li>
                            <li><a href="shop-grid-6cols.html">6 Columns Mode</a></li>
                            <li><a href="shop-grid-7cols.html">7 Columns Mode</a></li>
                            <li><a href="shop-grid-8cols.html">8 Columns Mode</a></li>
                            <li><a href="shop-list.html">List Mode</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-sm-4 col-md-3 col-lg-4 menu-banner menu-banner1 banner banner-fixed">
                        <figure>
                            <img src="{{ Helper::frontend('images/menu/banner-1.jpg') }}" alt="Menu banner" width="221"
                                height="330" />
                        </figure>
                        <div class="banner-content y-50">
                            <h4 class="banner-subtitle font-weight-bold text-primary ls-m">Sale.
                            </h4>
                            <h3 class="banner-title font-weight-bold"><span class="text-uppercase">Up to</span>70% Off
                            </h3>
                            <a href="#" class="btn btn-link btn-underline">shop now<i
                                    class="d-icon-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </li> -->
      
        <li>
            <a href="{{ route('confirmation') }}">Payment</a>
        </li>
        
        <li>
            <a href="{{ route('contact') }}">Contact Us</a>
        </li>
    </ul>
</nav>

<!-- <span class="divider"></span>

<div class="header-search hs-toggle">
    <a href="#" class="search-toggle">
        <i class="d-icon-search"></i>
    </a>
    <form action="#" class="input-wrapper">
        <input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search your keyword..."
            required />
        <button class="btn btn-search" type="submit">
            <i class="d-icon-search"></i>
        </button>
    </form>
</div> -->