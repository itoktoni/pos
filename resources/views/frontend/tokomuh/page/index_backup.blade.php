@extends(Helper::setExtendFrontend())
@section('content')
<div class="page-content">

    @include(Helper::setExtendFrontend('homepage.slider'))
    @include(Helper::setExtendFrontend('homepage.category'))
    @include(Helper::setExtendFrontend('homepage.promo'))
    @livewire('ecommerce.bestseller-livewire')

    <section class="product-wrapper pb-10 container appear-animate" data-animation-options="{
                    'delay': '.6s'
                }">
        <h2 class="title">Product Baru</h2>
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
            <div class="product">
                <figure class="product-media">
                    <a href="product.html">
                        <img src="{{ Helper::frontend('images/demos/demo1/products/product5.jpg') }}"
                            alt="Blue Pinafore Denim Dress" width="220" height="245">
                    </a>
                    <div class="product-label-group">
                        <label class="product-label label-sale">27% off</label>
                    </div>
                    <div class="product-action-vertical">
                        <a href="#" class="btn-product-icon btn-cart" data-toggle="modal" data-target="#addCartModal"
                            title="Add to cart"><i class="d-icon-bag"></i></a>
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
                        <a href="product.html">Women's Brown leather backpacks</a>
                    </h3>
                    <div class="product-price">
                        <ins class="new-price">$230.00</ins><del class="old-price">$210.00</del>
                    </div>
                    <div class="ratings-container">
                        <div class="ratings-full">
                            <span class="ratings" style="width:100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                        <a href="product.html" class="rating-reviews">( 6 reviews )</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <figure class="product-media">
                    <a href="product.html">
                        <img src="{{ Helper::frontend('images/demos/demo1/products/product6.jpg') }}"
                            alt="Blue Pinafore Denim Dress" width="220" height="245">
                    </a>
                    <div class="product-label-group">
                        <label class="product-label label-sale">27% off</label>
                    </div>
                    <div class="product-action-vertical">
                        <a href="#" class="btn-product-icon btn-cart" data-toggle="modal" data-target="#addCartModal"
                            title="Add to cart"><i class="d-icon-bag"></i></a>
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
                        <a href="product.html">Spon wide-striped shirt</a>
                    </h3>
                    <div class="product-price">
                        <ins class="new-price">$199.00</ins><del class="old-price">$210.00</del>
                    </div>
                    <div class="ratings-container">
                        <div class="ratings-full">
                            <span class="ratings" style="width:100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                        <a href="product.html" class="rating-reviews">( 6 reviews )</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <figure class="product-media">
                    <a href="product.html">
                        <img src="{{ Helper::frontend('images/demos/demo1/products/product7.jpg') }}"
                            alt="Blue Pinafore Denim Dress" width="220" height="245">
                    </a>
                    <div class="product-action-vertical">
                        <a href="#" class="btn-product-icon btn-cart" data-toggle="modal" data-target="#addCartModal"
                            title="Add to cart"><i class="d-icon-bag"></i></a>
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
                        <a href="product.html">Beyond Donald -original-trucker</a>
                    </h3>
                    <div class="product-price">
                        <span class="price">$35.00</span>
                    </div>
                    <div class="ratings-container">
                        <div class="ratings-full">
                            <span class="ratings" style="width:100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                        <a href="product.html" class="rating-reviews">( 6 reviews )</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <figure class="product-media">
                    <a href="product.html">
                        <img src="{{ Helper::frontend('images/demos/demo1/products/product8.jpg') }}"
                            alt="Blue Pinafore Denim Dress" width="220" height="245">
                    </a>
                    <div class="product-action-vertical">
                        <a href="#" class="btn-product-icon btn-cart" data-toggle="modal" data-target="#addCartModal"
                            title="Add to cart"><i class="d-icon-bag"></i></a>
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
                        <a href="product.html">Vans Black all star trainer</a>
                    </h3>
                    <div class="product-price">
                        <span class="price">$19.00</span>
                    </div>
                    <div class="ratings-container">
                        <div class="ratings-full">
                            <span class="ratings" style="width:100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                        <a href="product.html" class="rating-reviews">( 6 reviews )</a>
                    </div>
                </div>
            </div>
            <div class="product">
                <figure class="product-media">
                    <a href="product.html">
                        <img src="{{ Helper::frontend('images/demos/demo1/products/product9.jpg') }}"
                            alt="Blue Pinafore Denim Dress" width="220" height="245">
                    </a>
                    <div class="product-action-vertical">
                        <a href="#" class="btn-product-icon btn-cart" data-toggle="modal" data-target="#addCartModal"
                            title="Add to cart"><i class="d-icon-bag"></i></a>
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
                        <a href="product.html">Converse kids one star suede eclipsepulse</a>
                    </h3>
                    <div class="product-price">
                        <ins class="new-price">$98.00</ins><del class="old-price">$210.00</del>
                    </div>
                    <div class="ratings-container">
                        <div class="ratings-full">
                            <span class="ratings" style="width:100%"></span>
                            <span class="tooltiptext tooltip-top"></span>
                        </div>
                        <a href="product.html" class="rating-reviews">( 6 reviews )</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

   

    <section class="grey-section pt-10 pb-5">
        <div class="container mt-3 mb-4">
            <h2 class="title">Article Kami</h2>
            <div class="owl-carousel owl-theme row cols-md-2 cols-1" data-owl-options="{
                            'items': 2,
                            'nav': false,
                            'dots': true,
                            'loop': false,
                            'margin': 20,
                            'responsive': {
                                '0': {
                                    'items': 1
                                },
                                '768': {
                                    'items': 2,
                                    'dots': false
                                }
                            }
                        }">
                <div class="post post-list overlay-dark overlay-zoom appear-animate" data-animation-options="{
                                'name': 'fadeInRightShorter',
                                'delay': '.3s'
                            }">
                    <figure class="post-media">
                        <a href="post-single.html">
                            <img src="{{ Helper::frontend('images/demos/demo1/blog/post1.jpg') }}" width="280"
                                height="206" alt="post" />
                        </a>
                        <div class="post-calendar">
                            <span class="post-day">19</span>
                            <span class="post-month">JAN</span>
                        </div>
                    </figure>
                    <div class="post-details">
                        <h4 class="post-title"><a href="post-single.html">20% Off Coupon for Cyber Week</a>
                        </h4>
                        <p class="post-content">Lorem ipsum dolor sit amet,onadipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua tempo...</p>
                        <a href="post-single.html" class="btn btn-outline btn-md btn-dark btn-icon-right">Read More<i
                                class="d-icon-arrow-right"></i></a>
                    </div>
                </div>
                <div class="post post-list overlay-dark overlay-zoom appear-animate" data-animation-options="{
                                'name': 'fadeInRightShorter',
                                'delay': '.4s'
                            }">
                    <figure class="post-media">
                        <a href="post-single.html">
                            <img src="{{ Helper::frontend('images/demos/demo1/blog/post2.jpg') }}" width="280"
                                height="206" alt="post" />
                        </a>
                        <div class="post-calendar">
                            <span class="post-day">19</span>
                            <span class="post-month">JAN</span>
                        </div>
                    </figure>
                    <div class="post-details">
                        <h4 class="post-title"><a href="post-single.html">30% Discount for Shoes &amp;
                                Bags</a></h4>
                        <p class="post-content">Lorem ipsum dolor sit amet,onadipiscing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua tempo...</p>
                        <a href="post-single.html" class="btn btn-outline btn-md btn-dark btn-icon-right">Read More<i
                                class="d-icon-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection