@extends(Helper::setExtendFrontend())

@section('content')
<hr>
<main class="main mt-4">
    <div class="page-content mb-10">
        <div class="container">
            <div class="product product-single row mb-4">
                <div class="col-md-6">
                    <div class="product-gallery pg-vertical">
                        <div class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1">
                            <figure class="product-image">
                                <img src="{{ Helper::files('product/'.$oproduct->item_product_image) }}"
                                    alt="{{ $oproduct->item_product_name }}" width="800" height="900">
                            </figure>
                            @foreach($images as $image)
                            <figure class="product-image">
                                <img src="{{ Helper::files('product_detail/thumbnail_'.$image->item_product_image_file) }}"
                                    alt="Women's Brown Leather Backpacks" width="800" height="900">
                            </figure>
                            @endforeach
                        </div>
                        <div class="product-thumbs-wrap">
                            <div class="product-thumbs">
                                <div class="product-thumb active">
                                    <img src="{{ Helper::files('product/'.$oproduct->item_product_image) }}"
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
                    @livewire('ecommerce.product-livewire', ['slug' => $slug])
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

        </div>
    </div>
</main>
@endsection