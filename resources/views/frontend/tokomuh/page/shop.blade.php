@extends(Helper::setExtendFrontend())

@push('css')
<link rel="stylesheet" type="text/css" href="{{ Helper::frontend('vendor/nouislider/nouislider.min.css') }}">
@endpush

@push('js')
<script src="{{ Helper::frontend('vendor/nouislider/nouislider.min.js') }}"></script>
@endpush

@section('content')

<!-- End PageHeader -->
<div class="shopping page-content mb-10">
    <div class="container">
    @livewire('ecommerce.shop-livewire')
    </div>
</div>

@endsection
