@extends(Helper::setExtendFrontend())

@section('content')
<main class="main">
    <hr>
    <!-- End PageHeader -->
    <div class="page-content mb-10">
        <div class="container">
            <div class="row main-content-wrap gutter-lg">

                <div class="col-lg-12 main-content">

                    <div class="product-lists product-wrapper">
                        @foreach($data_wishlist as $wishlist)
                        <div class="product product-list">
                            <figure class="product-media">
                                <a href="{{ route('product', ['slug' => $wishlist->item_product_slug]) }}">
                                    <img src="{{ Helper::files('product/'.$wishlist->item_product_image) }}"
                                        alt="product" width="260" height="293">
                                </a>
                            </figure>
                            <div class="product-details">
                                <div class="product-cat">
                                    <a href="shop-grid-3col.html">{{ $wishlist->item_category_name }}</a>
                                </div>
                                <h3 class="product-name">
                                    <a href="{{ route('product', ['slug' => $wishlist->item_product_slug]) }}">
                                        {{ $wishlist->item_product_name }}
                                    </a>
                                </h3>

                                <hr class="product-divider">
                                <div class="product-price">
                                    <span class="price">
                                        Rp.{{ Helper::createRupiah($wishlist->item_product_price) }}
                                    </span>
                                </div>

                                <p class="product-short-desc">
                                    {!! $wishlist->item_product_description !!}
                                </p>
                                <div class="product-action">
                                    <a href="{{ route('product', ['slug' => $wishlist->item_product_slug]) }}"
                                        class="btn btn-default btn-md">View Product</a>
                                    <a href="{{ route('wishlist', ['remove' => $wishlist->item_wishlist_id]) }}"
                                        class="btn btn-alert btn-md ml-2">Remove</a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <nav class="toolbox toolbox-pagination mt-6">
                        <p class="show-info">Showing <span>{{ $data_wishlist->firstItem() }} to {{ $data_wishlist->lastItem() }} of {{$data_wishlist->total()}}</span> Data</p>
                        <ul class="pagination">
                            {{ $data_wishlist->links() }}
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection