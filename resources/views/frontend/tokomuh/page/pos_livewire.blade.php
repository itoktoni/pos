@push('css')
<style>
.action{
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
}
</style>
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
                    <a class="btn btn-info btn-block mb-2" href="{{ route('logout') }}">
                        {{ auth()->user()->name ?? '' }}
                    </a>
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
                    <h6 style="font-size: 12px;text-align:center;margin-top:5px">{{ $product->item_product_name }}</h6>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    @php
    $bayar = session('bayar');
    $total = Cart::getSubTotal();
    $kembalian = $bayar > 0 ? $bayar - $total : 0;
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
                                <th>Uang <h4 style="cursor: pointer;">
                                        {{ Helper::createRupiah($bayar) }}</h4>
                                </th>
                                <th>Kembalian <h4>{{ Helper::createRupiah($kembalian) }}</h4>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="col-xl-5 col-lg-4 col-md-3 col-sm-12">
                <div class="row mt-2">
                    @foreach($data_uang as $key => $value)
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-2 mb-2" wire:click="actionBayar('{{ $value }}')">
                        <img width="100%" class="img-fluid" src="{{ Helper::files('uang/'.$key) }}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    <div class="fixed-bottom d-none d-md-block" style="background-color: #fff;margin-right:30px">

        <div class="row align-items-start">
            <div class="col-xl-4 col-md-6 col-lg-5 col-sm-12">
                <div class="table ml-3 mt-1">
                    <table class="table border">
                        <thead>
                            <tr>
                                <th class="name">Total
                                    <h2>
                                        {{ Helper::createRupiah($total) }}
                                    </h2>
                                </th>
                                <th>Uang
                                    <h2 style="cursor: pointer;" wire:click="resetBayar()">
                                        {{ Helper::createRupiah($bayar) }}
                                    </h2>
                                </th>
                                <th>Kembalian
                                    <h2>
                                        {{ Helper::createRupiah($kembalian) }}
                                    </h2>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="col-xl-5 col-lg-4 col-md-4 col-sm-12">
                <div class="row mt-1">
                    @foreach($data_uang as $key => $value)
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-2 mb-2" wire:click="actionBayar('{{ $value }}')">
                        <img class="img-fluid" src="{{ Helper::files('uang/'.$key) }}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-12 mt-1 mb-2">
                <div class="row">
                    <div class="container action">
                        <div class="row  align-items-center mb-2">
                            <div class="col-sm mr-2 pt-3 pb-3 text-center" wire:click="actionReset()"  style="background-color: #c0c0c0;color:black">
                                Refresh
                            </div>
                            <div class="col-sm pt-3 pb-3  text-center" wire:click="resetBayar()"  style="background-color: #DC3545;">
                                Reset
                            </div>
                            <div class="col-sm pt-3 pb-3 ml-2 text-center"  wire:click="printAntrian()" style="background-color: #427BFF;">
                                Antrian
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-sm pt-3 pb-3 mr-2 text-center"  wire:click="actionSync()" style="background-color: #F2C010;color:black">
                               Sync
                            </div>
                            <div class="col-sm pt-3 pb-3 text-center" wire:click="actionLogout()" style="background-color: black;">
                                Logout
                            </div>
                            <div wire:click="createOrder()" class="col-sm pt-3 pb-3 ml-2 text-center" style="background-color: #4FA746;">
                               Selesai
                            </div>
                        </div>

                    </div>
                    
                </div>
                
            </div>
        </div>

    </div>

</div>