<footer class="footer appear-animate">
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <div class="col-lg-2 col-sm-12">
                    <div class="social-links mb-5">
                        @if(isset($gsosmed))
                        @foreach($gsosmed as $sosmed)
                        <a href="{{ $sosmed->marketing_sosmed_link }}"
                            class="social-link social-facebook {{ $sosmed->marketing_sosmed_icon }}"></a>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-10 col-sm-12" id="subsribe">
                    <div class="widget widget-newsletter form-wrapper form-wrapper-inline">
                        <div class="mx-auto mb-3">
                            {!! config('website.newsletter') !!}
                        </div>

                        @livewire('ecommerce.subscribe-livewire')

                    </div>
                    <!-- End of Newsletter -->
                </div>
            </div>
        </div>
        <!-- End of FooterTop -->
        <div class="footer-middle">
            <div class="row">
                <div class="col-lg-6 col-md-6">

                    <div class="row">
                        <div class="widget">
                            <h4 class="widget-title">Informasi Toko Muhammadiyah</h4>
                            <ul class="widget-body">
                                <li>
                                    Alamat : {{ config('website.address') }}
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="widget">
                                <ul class="widget-body">
                                    <li>
                                        <label>Customer Service :</label>
                                        <a href="#">{{ config('website.phone') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="widget">
                                <ul class="widget-body">
                                    <li>
                                        <label>Email :</label>
                                        <a href="#">{{ config('website.email') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- End of Widget -->
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="widget ml-lg-4">
                        <h4 class="widget-title">Informasi Pembeli</h4>
                        <ul class="widget-body">
                            @foreach($gpage->where('marketing_page_status', 2)->all() as $pembeli)
                            <li><a
                                    href="{{ route('page', ['slug' => $pembeli->marketing_page_slug]) }}">{{ $pembeli->marketing_page_name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- End of Widget -->
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 last-link-footer mb-10">
                    <div class="widget ml-lg-4">
                        <h4 class="widget-title">Informasi Penjual</h4>
                        <ul class="widget-body">
                            @foreach($gpage->where('marketing_page_status', 1)->all() as $penjual)
                            <li><a
                                    href="{{ route('page', ['slug' => $penjual->marketing_page_slug]) }}">{{ $penjual->marketing_page_name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- End of Widget -->
                </div>
            </div>
        </div>
        <!-- End of FooterMiddle -->
    </div>
</footer>
</footer>