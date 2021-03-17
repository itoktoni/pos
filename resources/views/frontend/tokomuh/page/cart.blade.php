@extends(Helper::setExtendFrontend())

@section('content')

<main class="main cart">
    <div class="page-content pt-5 pb-10">
        @livewire('ecommerce.cart-livewire')
    </div>
</main>

@endsection