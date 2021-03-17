<main class="main">
    <hr>
    <!-- End PageHeader -->
    <div class="page-content mb-10">
        <div class="container">
            <div class="row main-content-wrap gutter-lg">

                <div class="col-md-12 main-content">
                    <nav class="toolbox toolbox-horizontal">

                        <div class="toolbox-left">
                            <h3 class="title title-simple mt-5">
                                List Order
                            </h3>
                        </div>

                        <div class="row col-md-3 toolbox-right">
                            <div class="header-search mb-3">
                                <div class="input-wrapper">
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search"
                                        value="{{ $search }}" id="search" placeholder="Search your keyword...">
                                    <button class="btn btn-sm btn-search" type="submit"><i
                                            class="d-icon-search"></i></button>
                                </div>
                            </div>
                        </div>

                    </nav>
                </div>

                <div class="col-lg-12 main-content">

                    <div class="product-lists product-wrapper" style="border-top: 0.5px solid #999;">
                        @foreach($data_order as $order)
                        <div class="product product-list">

                            <div class="col-md-12" style="padding:20px">
                                <div class="row gutter-lg" style="border: 0.5px solid #999;">

                                    <aside class="col-lg-5">
                                        <div class="sticky-sidebar">
                                            <div class="summary mb-5 mt-5">
                                                <h3 class="summary-title text-left">{{ $order->sales_order_from_name }}
                                                </h3>
                                                <table class="shipping mb-3">
                                                    <tbody>
                                                        <tr class="summary-subtotal">
                                                            <td class="pt-1 pb-1">
                                                                <span class="summary-subtitle">No.
                                                                    {{ $order->sales_order_id }}</span>
                                                            </td>
                                                            <td class="pt-1 pb-1">
                                                                <p class="summary-subtotal-price">
                                                                    {{ $status[$order->sales_order_status] }}</p>
                                                            </td>
                                                        </tr>
                                                        <tr class="summary-subtotal">
                                                            <td class="pt-1 pb-1">
                                                                <span class="summary-subtitle">Dikirim ke</span>
                                                            </td>
                                                            <td class="pt-1 pb-1">
                                                                <p class="summary-subtotal-price">
                                                                    {{ $order->sales_order_to_name }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr class="">
                                                            <td class="pt-2 pb-1">
                                                                <span class="summary-subtitle">
                                                                    No. Resi
                                                                </span>
                                                            </td>
                                                            <td class="pt-1 pb-1">
                                                                <p class="summary-subtotal-price">
                                                                    <a style="text-decoration: underline;"
                                                                        class="open-button"
                                                                        popup-open="popup-{{ $loop->iteration }}"
                                                                        href="javascript:void(0)">
                                                                        {{ $order->sales_order_courier_waybill ?? '' }}
                                                                    </a>
                                                                </p>
                                                            </td>

                                                            <div class="popup"
                                                                popup-name="popup-{{ $loop->iteration }}">
                                                                <div class="popup-content">
                                                                    <h4>
                                                                        Tracking Number :
                                                                        {{ $order->sales_order_courier_waybill }}
                                                                    </h4>

                                                                    @if($order->track->count() > 0)
                                                                    <div style="height: 500px;overflow-y: scroll;">
                                                                        @foreach($order->track->sortByDesc('order_tracking_date')
                                                                        as $tracking)
                                                                        <div
                                                                            style="background-color: whitesmoke;padding:1rem;margin-bottom:1rem;">
                                                                            <div style="width: 100%;">

                                                                                <p style="margin-bottom:-0px">
                                                                                    <strong>Tanggal</strong> :
                                                                                    {{ $tracking->order_tracking_date }}
                                                                                </p>

                                                                                <p style="margin-bottom:-0px">
                                                                                    <strong>Lokasi</strong> :
                                                                                    {{ $tracking->order_tracking_location }}
                                                                                </p>

                                                                                <p style="margin-bottom:-0px">
                                                                                    <strong>Keterangan :
                                                                                    </strong>
                                                                                    {{ $tracking->order_tracking_description }}
                                                                                </p>
                                                                            </div>

                                                                        </div>
                                                                        @endforeach
                                                                        @endif
                                                                    </div>

                                                                </div>

                                                                <a class="close-button"
                                                                    popup-close="popup-{{ $loop->iteration }}"
                                                                    href="javascript:void(0)"></a>
                                                            </div>
                                            </div>

                                            </tr>

                                            </tbody>

                                            </table>

                                        </div>
                                </div>
                                </aside>

                                <div class="col-lg-7 col-md-12">
                                    <table class="shop-table cart-table mt-5 mb-3">

                                        <thead>
                                            <tr style="border-bottom: 1px solid grey;">
                                                <th>
                                                    <span>
                                                        Product
                                                    </span>
                                                </th>
                                                <th class="text-right"><span>Order</span></th>
                                                <th class="text-right"><span>Receive</span></th>
                                                <th class="text-right"><span>Price</span></th>
                                                <th class="text-right">total</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach($order->detail as $detail)
                                            <tr>
                                                <th class="text-left">
                                                    <span class="text-grey">
                                                        {{ $detail->sales_order_detail_item_product_description }}
                                                    </span>
                                                </th>
                                                <th class="text-right"><span
                                                        class="mr-2 text-grey">{{ $detail->sales_order_detail_qty }}</span>
                                                </th>
                                                <th class="text-right"><span
                                                        class="mr-2 text-grey">{{ $detail->sales_order_detail_sent }}</span>
                                                </th>
                                                <th class="text-right"><span
                                                        class="text-grey">{{ Helper::createRupiah($detail->sales_order_detail_price) }}</span>
                                                </th>
                                                <th class="text-right"><span
                                                        class="text-grey">{{ Helper::createRupiah($detail->sales_order_detail_total) }}</span>
                                                </th>
                                            </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr style="border-bottom: 0.5px solid whitesmoke;">
                                                <th colspan="4">
                                                    <span>
                                                        Total
                                                    </span>
                                                </th>
                                                <th class="text-right">
                                                    <span>{{ Helper::createRupiah($order->sales_order_sum_product) }}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-left" colspan="4">
                                                    <span>
                                                        Ongkir
                                                    </span>
                                                </th>
                                                <th class="text-right">
                                                    <span>{{ Helper::createRupiah($order->sales_order_sum_ongkir) }}</span>
                                                </th>
                                            </tr>
                                            <tr style="border-top: 0.5px solid #999;">
                                                <th colspan="4">
                                                    <span>
                                                        Grand Total
                                                    </span>
                                                </th>
                                                <th class="text-right">
                                                    <span>{{ Helper::createRupiah($order->sales_order_sum_total) }}</span>
                                                </th>
                                            </tr>
                                        </tfoot>


                                    </table>

                                </div>

                            </div>
                        </div>

                    </div>
                    @endforeach

                </div>
                <nav class="toolbox toolbox-pagination mt-6">
                    <p class="show-info">Showing <span>{{ $data_order->firstItem() }} to
                            {{ $data_order->lastItem() }} of {{$data_order->total()}}</span> Data</p>
                    <ul class="pagination">
                        {{ $data_order->links() }}
                    </ul>
                </nav>
            </div>

        </div>
    </div>
    </div>
</main>

@push('javascript')
<script>
$(function() {
    // Open Popup
    $('[popup-open]').on('click', function() {
        var popup_name = $(this).attr('popup-open');
        $('[popup-name="' + popup_name + '"]').fadeIn(300);
    });

    // Close Popup
    $('[popup-close]').on('click', function() {
        var popup_name = $(this).attr('popup-close');
        $('[popup-name="' + popup_name + '"]').fadeOut(300);
    });

    // Close Popup When Click Outside
    $('.popup').on('click', function() {
        var popup_name = $(this).find('[popup-close]').attr('popup-close');
        $('[popup-name="' + popup_name + '"]').fadeOut(300);
    }).children().click(function() {
        return false;
    });

});
</script>

<style>
.popup {
    position: fixed;
    top: 0px;
    left: 0px;
    background: rgba(0, 0, 0, 0.75);
    width: 100%;
    height: 100%;
    display: none;
    z-index: 999;
}

/* Popup inner div */
.popup-content {
    width: 700px;
    margin: 0 auto;
    box-sizing: border-box;
    padding: 20px;
    margin-top: 100px;
    box-shadow: 0px 2px 6px rgba(0, 0, 0, 1);
    border-radius: 3px;
    background: #fff;
    position: relative;
    z-index: 9999999;
}

.close-button:hover {
    background: rgba(0, 0, 0, 1);
}

@media screen and (max-width: 720px) {
    .popup-content {
        width: 90%;
    }
}
</style>

@endpush

