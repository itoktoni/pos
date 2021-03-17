@extends(Helper::setExtendFrontend())

@section('content')
<main class="main checkout">
    <div class="page-content pt-7 pb-10">
        @livewire('ecommerce.checkout-livewire')
    </div>
</main>
@endsection