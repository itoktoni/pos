@extends(Helper::setExtendFrontend())
@section('content')
<div class="page-content">

    @include(Helper::setExtendFrontend('homepage.slider'))
    @include(Helper::setExtendFrontend('homepage.category'))
    @include(Helper::setExtendFrontend('homepage.promo'))
    @include(Helper::setExtendFrontend('homepage.best_seller'))
    @include(Helper::setExtendFrontend('homepage.new_product'))

</div>
@endsection