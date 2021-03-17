@push('css')

@endpush

<div class="container-fluid">

    <div class="row center category mt-2">
        @foreach($data_category as $cat)
        <button class="col-md col-xs button mr-1 ml-1 pb-3 pt-3"
            {{ $cat->item_category_slug == $murah ? 'active' : '' }}
            wire:click="actionCategory('{{ $cat->item_category_slug }}')">
            {{ $cat->item_category_name }}
        </button>
        @endforeach
    </div>

    <div class="row mt-3">

        <div class="col-lg-5 col-md-6 col-xl-4">

            <div class="row">
                <div class="col-md-5 col-lg-6">
                    <h4 class="btn btn-info btn-block">
                        {{ auth()->user()->name ?? '' }}
                    </h4>
                </div>

                <div class="col-md-7 col-lg-6">
                    {{ $data_product->onEachSide(1)->links() }}
                </div>
            </div>

            <div class="row" style="height: 65vh;overflow-y: auto;">

                <table class="table border">
                    <thead>
                        <tr>
                            <th class="name">Product</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Harga</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    @if(!Cart::isEmpty())
                    <tbody>
                        @foreach(Cart::getContent()->sort() as $cart)
                        <tr>
                            <td>
                                <button wire:click="actionMinus('{{ $cart->id }}')"
                                    class="btn btn-danger btn-block text-right btn-sm">
                                    {{ $cart->name }}
                                </button>
                            </td>
                            <td class="text-center">{{ $cart->quantity }}</td>
                            <td class="text-right">{{ Helper::createRupiah($cart->price) }}</td>
                            <td class="text-right">{{ Helper::createRupiah($cart->getPriceSum()) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>

            </div>

        </div>

        <div class="col-lg-7 col-md-6 col-xl-8">
            <div class="row" style="height: 100%;overflow-y: auto;">
                @foreach($data_product as $product)
                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-xs-6 mb-3"
                    wire:click="actionCart('{{ $product->item_product_id }}')">
                    <img style="width: 100%;" src="{{ Helper::files('product/'.$product->item_product_image) }}"
                        class="img-fluid" alt="...">
                </div>
                @endforeach
            </div>

        </div>
    </div>

    @php
    $bayar = session('bayar');
    $total = Cart::getSubTotal();
    $kembalian = $total - $bayar;
    @endphp

    <div class="d-md-none" style="background-color: #fff;">
        <div class="row align-items-start">

            <div class="col-xl-4 col-md-6 col-lg-5 col-sm-12">
                <div class="table mt-1">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th class="name">Total <h4>{{ Helper::createRupiah($total) }}</h4>
                                </th>
                                <th>Uang <h4 style="cursor: pointer;" wire:click="resetBayar()">
                                        {{ Helper::createRupiah($bayar) }}</h4>
                                </th>
                                <th>Kembalian <h4>{{ Helper::createRupiah($kembalian) }}</h4>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="col-xl-6 col-lg-5 col-md-4 col-sm-12">
                <div class="row mt-2">
                    @foreach($data_uang as $key => $value)
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-2 mb-2" wire:click="actionBayar('{{ $value }}')">
                        <img width="100%" class="img-fluid" src="{{ Helper::files('uang/'.$key) }}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-12 mt-2 mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success col-md-10 mb-2" wire:click="actionReset()">Baru</button>
                        <button class="btn btn-danger col-md-10" wire:click="createOrder()">Cetak</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="fixed-bottom d-none d-md-block" style="background-color: #fff;">

        <div class="row align-items-start">
            <div class="col-xl-4 col-md-6 col-lg-5 col-sm-12">
                <div class="table ml-3 mt-1">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th class="name">Total <h4>{{ Helper::createRupiah($total) }}</h4>
                                </th>
                                <th>Uang <h4 style="cursor: pointer;" wire:click="resetBayar()">
                                        {{ Helper::createRupiah($bayar) }}</h4>
                                </th>
                                <th>Kembalian <h4>{{ Helper::createRupiah($kembalian) }}</h4>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="col-xl-6 col-lg-5 col-md-4 col-sm-12">
                <div class="row mt-2">
                    @foreach($data_uang as $key => $value)
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-2 mb-2" wire:click="actionBayar('{{ $value }}')">
                        <img class="img-fluid" src="{{ Helper::files('uang/'.$key) }}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-12 mt-2">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success col-md-10 mb-2" wire:click="actionReset()">Baru</button>
                        <button class="btn btn-danger col-md-10" wire:click="createOrder()">Cetak</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>