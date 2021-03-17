<!-- Plugins JS File -->
<script src="{{ Helper::frontend('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ Helper::frontend('vendor/parallax/parallax.min.js') }}"></script>
<script src="{{ Helper::frontend('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ Helper::frontend('vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ Helper::frontend('vendor/owl-carousel/owl.carousel.min.js') }}"></script>
<!-- Main JS File -->
<script src="{{ Helper::frontend('js/main.js') }}"></script>
@stack('js')
@stack('javascript')