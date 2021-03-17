<section class="intro-section">
    <div class="owl-carousel owl-theme row owl-dot-inner owl-dot-white intro-slider animation-slider cols-1 gutter-no"
        data-owl-options="{
                        'nav': false,
                        'dots': true,
                        'loop': true,
                        'items': 1,
                        'autoplay': true,
                        'autoplayTimeout': 8000
                    }">

        @forelse ($sliders as $slider)
        @switch($slider->marketing_slider_type)
        @case('left')
        <div class="banner banner-fixed intro-slide1" style="background-color: #{{ $slider->marketing_slider_background }};">
            <figure>
                <img src="{{ Helper::files('slider/'.$slider->marketing_slider_image) }}" alt="{{ $slider->marketing_slider_name }}"
                    width="1900" height="630" />
            </figure>
            <div class="container">
                <div class="banner-content y-50 ml-auto text-left">
                    {!! $slider->marketing_slider_page !!}
                    @isset($slider->marketing_slider_link)
                    <a href="{{ $slider->marketing_slider_link }}" class="btn btn-dark slide-animate"
                        data-animation-options="{'name': 'fadeInUp', 'duration': '1s', 'delay': '1.4s'}">
                        {{ $slider->marketing_slider_button ? $slider->marketing_slider_button : 'Shop Now' }}
                    </a>
                    @endisset
                </div>
            </div>
        </div>
        @break

        @case('right')
        <div class="banner banner-fixed intro-slide2"
            style="background-color: #{{ $slider->marketing_slider_background }};">
            <figure>
                <img src="{{ Helper::files('slider/'.$slider->marketing_slider_image) }}" alt="{{ $slider->marketing_slider_name }}"
                    width="1900" height="630" />
            </figure>
            <div class="container">
                <div class="banner-content y-50 ml-auto text-right">
                    {!! $slider->marketing_slider_page !!}
                    @isset($slider->marketing_slider_link)
                    <a href="{{ $slider->marketing_slider_link }}" class="btn btn-dark slide-animate"
                        data-animation-options="{'name': 'fadeInUp', 'duration': '1s', 'delay': '1.4s'}">
                        {{ $slider->marketing_slider_button ? $slider->marketing_slider_button : 'Shop Now' }}
                    </a>
                    @endisset
                </div>
            </div>
        </div>
        @break

        @case('center')
        <div class="banner banner-fixed intro-slide3"
            style="background-color: #{{ $slider->marketing_slider_background }};">
            <figure>
                <img src="{{ Helper::files('slider/'.$slider->marketing_slider_image) }}" alt="{{ $slider->marketing_slider_name }}"
                    width="1900" height="630" />
            </figure>
            <div class="container">
                <div class="banner-content y-50 ml-auto text-center">
                    {!! $slider->marketing_slider_page !!}
                    @isset($slider->marketing_slider_link)
                    <a href="{{ $slider->marketing_slider_link }}" class="btn btn-dark slide-animate"
                        data-animation-options="{'name': 'fadeInUp', 'duration': '1s', 'delay': '1.4s'}">
                        {{ $slider->marketing_slider_button ? $slider->marketing_slider_button : 'Shop Now' }}
                    </a>
                    @endisset
                </div>
            </div>
        </div>
        @break
        
        @case('video')
        <div class="banner banner-fixed video-banner intro-slide3" style="background-color: #dddee0;">
            <figure>
                <video src="{{ Helper::frontend('video/memory-of-a-woman.mp4') }}" width="1900" height="630"></video>
            </figure>
            <div class="container">
            <div class="banner-content y-50 ml-auto text-center">
                    {!! $slider->marketing_slider_page !!}
                    @isset($slider->marketing_slider_link)
                    <a href="{{ $slider->marketing_slider_link }}" class="btn btn-dark slide-animate"
                        data-animation-options="{'name': 'fadeInUp', 'duration': '1s', 'delay': '1.4s'}">
                        {{ $slider->marketing_slider_button ? $slider->marketing_slider_button : 'Shop Now' }}
                    </a>
                    @endisset
                </div>
            </div>
        </div>
        @break
        
        @endswitch

        @empty
        @endforelse
        
    </div>

</section>