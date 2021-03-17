<section class="mt-md-9 mt-6 mb-10 container">
    <h2 class="title">Promo</h2>
    <div class="owl-carousel owl-theme row owl-nav-full cols-lg-4 cols-md-3 cols-sm-2 cols-1" data-owl-options="{
                            'nav': true,
                            'dots': false,
                            'items': 3,
                            'margin':  20,
                            'responsive': {
                                '0': {
                                    'items': 1 
                                },
                                '576': {
                                    'items': 2
                                },
                                '768': {
                                    'items': 3
                                }
                            }
                        }">
        @forelse($promos as $promo)
        <div class="category category-light category-absolute">
            <a href="{{ route('promo_page', ['slug' => $promo->marketing_promo_slug])}}">
                <div class="banner banner-2 banner-fixed content-middle content-center overlay-light appear-animate">
                    <figure>
                        <img src="{{ Helper::files('promo/'.$promo->marketing_promo_image) }}"
                            alt="{{ $promo->marketing_promo_name }}" width="380" height="250" />
                    </figure>
                    <div class="banner-content">
                        <h3 class="banner-title font-weight-bold mb-2 mt-5">{{ $promo->marketing_promo_name }}</h3>
                        {!! $promo->marketing_promo_description !!}
                        @if(!empty($promo->marketing_promo_link))
                        <a href="{{ $promo->marketing_promo_link }}" class="btn btn-dark btn-md mt-3 mb-5">
                            {{ !empty($promo->marketing_promo_button) ? $promo->marketing_promo_button : 'SHOP NOW' }}
                        </a>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @empty
        @endforelse

    </div>
</section>