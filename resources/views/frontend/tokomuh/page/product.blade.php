@extends(Helper::setExtendFrontend())

@section('content')

<hr>

@livewire('ecommerce.product-livewire', ['oproduct' => $oproduct, 'variants' => $variants, 'images' => $images])

@endsection