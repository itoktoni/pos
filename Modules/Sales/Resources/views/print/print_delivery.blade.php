<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style>
    body {
        margin: 10px;
    }

    table#border {
        border: 0.5px solid grey;
    }

    .print-only {
        display: none !important
    }

    * {
        background: transparent !important;
        color: black !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        text-shadow: none !important;
        -webkit-filter: none !important;
        filter: none !important;
        -ms-filter: none !important
    }

    *,
    *:before,
    *:after {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box
    }

    a,
    a:visited {
        text-decoration: underline
    }

    a[href]:after {
        content: "("attr(href) ")"
    }

    abbr[title]:after {
        content: "("attr(title) ")"
    }

    .ira:after,
    a[href^="javascript:"]:after,
    a[href^="#"]:after {
        content: ""
    }

    pre,
    blockquote {
        border: 1px solid #999;
        page-break-inside: avoid
    }

    thead {
        display: table-header-group
    }

    tr,
    img {
        page-break-inside: avoid
    }

    img {
        max-width: 100% !important;
        vertical-align: middle;
        max-height: 100% !important
    }

    table {
        border-collapse: collapse
    }

    th,
    td {
        border: solid 1px #333;
        padding: 0.25em 8px;
        vertical-align: top
    }

    dl {
        margin: 0
    }

    dd {
        margin: 0
    }

    @page {
        margin: 1.25cm 0.5cm
    }

    p,
    h2,
    h3 {
        orphans: 3;
        widows: 3
    }

    h2,
    h3 {
        page-break-after: avoid
    }

    .hide-on-print {
        display: none !important
    }

    .print-only {
        display: block !important
    }

    .hide-for-print {
        display: none !important
    }

    .show-for-print {
        display: inherit !important
    }

    .break-page-after {
        page-break-after: always;
        page-break-inside: avoid
    }

    html {
        overflow-x: visible
    }

    body {
        font-size: 12px;
        line-height: 1.5;
        font-family: "sans-serif",
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-weight: normal
    }

    h1 a,
    h2 a,
    h3 a,
    h4 a,
    h5 a,
    h6 a {
        font-weight: inherit
    }

    h2 {
        font-size: 2em;
        line-height: 1.5;
        margin-bottom: 0.75em
    }

    h3 {
        font-size: 1.5em;
        line-height: 1;
        margin-top: 2em;
        margin-bottom: 1em
    }

    h4 {
        font-size: 1.25em;
        line-height: 2.4
    }

    h5 {
        font-weight: bold;
        margin-top: 2.25em;
        margin-bottom: 0.75em
    }

    h6 {
        text-transform: uppercase;
        margin-top: 2.25em;
        margin-bottom: 0.75em
    }

    #page {
        width: 100%;
        position: relative
    }

    .bukalapak-transaction-slip {
        padding: 8px 9px;
        border: solid 1px #000;
        margin-bottom: 18px;
        width: 100%;
        position: relative
    }

    .bukalapak-transaction-slip--brand {
        height: 27px;
        display: block;
        float: left
    }

    .bukalapak-transaction-slip--heading {
        margin-top: 0;
        display: block;
        float: right;
        line-height: 1;
        font-size: 18px
    }

    .bukalapak-transaction-slip--courier {
        margin-top: -5px;
        display: block;
        float: right;
        font-size: 14px;
        position: relative;
        width: 100%;
        text-align: right
    }

    .bukalapak-transaction-slip-buyer {
        margin-top: 9px;
        margin-bottom: 9px;
        padding-right: 18px;
        clear: both;
        float: left;
        width: 62%;
        border-right: dotted 1px #000
    }

    .bukalapak-transaction-slip-buyer--heading {
        font-weight: bold;
        margin-top: 0
    }

    .bukalapak-transaction-slip-buyer--label {
        display: block;
        float: left;
        clear: both;
        width: 25%
    }

    .bukalapak-transaction-slip-buyer--label:after {
        content: ":"
    }

    .bukalapak-transaction-slip-buyer--name,
    .bukalapak-transaction-slip-buyer--phone {
        font-weight: bold
    }

    .bukalapak-transaction-slip-buyer--address {
        display: block;
        float: left;
        font-weight: bold;
        width: 75%;
        white-space: -moz-pre-wrap !important;
        white-space: -pre-wrap;
        white-space: -o-pre-wrap;
        white-space: pre-wrap;
        white-space: normal
    }

    .bukalapak-transaction-slip-seller {
        display: block;
        float: left;
        width: 38%;
        margin-top: 9px;
        margin-bottom: 9px;
        padding-left: 18px
    }

    .bukalapak-transaction-slip-seller--heading {
        font-weight: bold;
        margin-top: 0em
    }

    .bukalapak-transaction-slip-seller--lapak,
    .bukalapak-transaction-slip-seller--name {
        white-space: nowrap
    }

    .bukalapak-transaction-slip--footer {
        display: block;
        width: 100%;
        clear: both;
        margin-top: 18px;
        border-top: solid 1px #000;
        padding-top: 5px;
        font-size: 9px
    }

    .bukalapak-transaction-product {
        clear: both;
        position: relative;
        width: 100%
    }

    .bukalapak-transaction-product-item {
        width: 80%
    }

    .bukalapak-transaction-product-quantity {
        width: 20%
    }

    .address p {
        margin-top: 0px;
        margin-bottom: 0px;
    }

    #description {
        line-height: 0.9px !important;
    }

    #logo {
        height: 100px;
        margin-top: 0px;
    }

    #box {
        position: absolute;
        right: 0;
        text-align: right;
        top: -30px;
    }

    #box h1 {
        margin-bottom: 0px;
        margin-right: -15px;
        font-size: 25px;
    }

    #box h2 {
        position: absolute;
        top: 70px;
        right: -3;
        text-align: right;
        font-size: 12px;
    }

    #box table {
        position: absolute;
        top: 0px;
        right: 0px;
        width: 280px;
        font-size: 10px;
    }

    #box table .head {
        width: 80px;
        text-align: right;
    }

    #address {
        margin-bottom: 20px;
        position: absolute;
        top: 0px;
        margin-left: 0px;
    }

    #address h4 {
        font-size: 12px;
    }

    #address p {
        margin-top: -25px;
        font-size: 10px;
        margin-bottom: 50px;
    }

    #container {
        margin-top: 0px;
    }

    #container table {
        width: 100% !important;
    }

    #container table .destination td {
        background-color: #F5F5F5 !important;
        text-align: left;
    }

    #container table .contact {
        text-align: left;
    }

    #container table .contact strong {
        font-size: 15px;
    }

    #container table .person {
        margin-top: 20px;
    }

    #container table .contact td {
        padding-top: 5px;
        padding-bottom: 10px;
    }

    #container table .contact td p {
        line-height: 1px;
        margin-bottom: 0px;
    }

    #container table .rest {
        text-align: left;
    }

    #container #headline {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        padding-bottom: 5px;
        margin: 0px;
    }

    #container table .message {
        margin-top: 0px !important;
        vertical-align: middle !important;
        padding-bottom: 20px !important;
    }

    #container table .message p {
        margin-bottom: -15px !important;
        line-height: 15px !important;
    }

    #container table .header td {
        padding-bottom: 7px;
        background-color: #F5F5F5 !important;
    }

    #container table .header .no {
        width: 25px;
    }

    #container table .header .product {
        width: 350px;
    }

    #container table .header .qty {
        width: 50px;
        text-align: right;
    }

    #container table .header .price {
        width: 100px;
        text-align: right;
    }

    #container table .header .total {
        width: 100px;
        text-align: right;
    }

    #container table .item td {
        vertical-align: middle !important;
    }


    #container table .item .no {
        text-align: center;
    }

    #container table .item .qty {
        text-align: right;
    }

    #container table .item .price {
        text-align: right;
    }

    #container table .item .total {
        text-align: right;
    }

    #container table .item .total span {
        position: relative;
        font-weight: bold;
        display: block;
        right: 0px;
        font-size: 10px;
        margin-left: 5px;
    }

    #container table .item .product h1 {
        font-size: 12px;
        margin: 0px;
    }

    #container table .item .product h2 {
        font-size: 10px;
        font-weight: bold;
        margin: 0px;
    }

    #container table .item .product h3 {
        font-size: 10px;
        text-align: left;
        font-weight: bold;
        margin: 0px;
        margin-top: 5px;
    }

    #container table .item .product p {
        font-size: 10px;
        text-align: left;
        margin: 0px;
    }

    #container table .item .product span {
        position: relative;
        font-weight: bold;
        display: block;
        right: 0px;
        font-size: 10px;
        margin-left: 5px;
        margin-top: 20px;
    }

    #container table .total_product td {
        text-align: right;
        background-color: #F5F5F5 !important;
        padding-bottom: 10px;
    }

    #container table .total_discount td {
        text-align: right;
        background-color: #F5F5F5 !important;
        padding-bottom: 10px;
    }

    #container table .total_tax td {
        text-align: right;
        background-color: #F5F5F5 !important;
        padding-bottom: 10px;
    }

    #container table .total_sumary td {
        text-align: right;
        background-color: lightgray !important;
        padding-bottom: 10px;
        font-weight: bold;
    }

    #paraf {
        margin-top: 10px;
        width: 100%;
        font-size: 10px;
        margin-bottom: -50px;
    }

    #paraf .header td {
        background-color: #F5F5F5 !important;
    }

    #paraf .content .sign {
        height: 130px;
        vertical-align: bottom !important;
        text-align: center;
    }


    #paraf .content .description {
        vertical-align: middle !important;
        text-align: left;
        line-height: 1px;
    }

    #paraf .header .sign {
        width: 150px;
        text-align: center;
    }

    #paraf .header .term {
        text-align: left;
    }
    </style>

    <title>Delivery_{{ $master->sales_delivery_id ?? '' }}</title>
</head>

<body>
    <div id='page'>

        <div id="container">
            <table cellpadding="" 5 cellspacing="0" width="100%">
                <tr>
                    <td align='left' colspan='8' valign='middle'>
                        <h1 id="headline">
                            DELIVERY ORDER ( {{ $master->sales_delivery_id ?? '' }} )
                        </h1>
                    </td>
                </tr>
                <tr class="destination">
                    <td colspan='4'>
                        <strong>Branch</strong>
                    </td>
                    <td colspan='4'>
                        <strong>Description</strong>
                    </td>
                </tr>
                <tr class="contact">
                    <td colspan='4' align="left" style="vertical-align: middle;">
                        <strong>
                            From : {{ $master->from->branch_name ?? '' }} | To :  {{ $master->to->branch_name ?? '' }}
                        </strong>
                    </td>
                    <td colspan='4' class="message">
                        Order Date : {{ $master->sales_delivery_date->format('d F Y') }}
                        <br>
                        {{ $master->sales_delivery_notes_internal ?? '' }}
                    </td>
                </tr>

                <tr class="header">
                    <td class="no">
                        <strong>No.</strong>
                    </td>
                    <td class="product" colspan="4">
                        <strong>Product Name</strong>
                    </td>
                    <td class="price">
                        <strong>Price</strong>
                    </td>
                    <td class="qty">
                        <strong>Qty</strong>
                    </td>
                    <td class="total">
                        <strong>Total</strong>
                    </td>
                </tr>
                @foreach($detail as $item)
                <tr class="item">
                    <td class="no">
                        {{ $loop->iteration }}
                    </td>
                    <td class="product" colspan="4">
                        <h1>
                            {{ $item->product->item_product_name ?? '' }}
                        </h1>
                    </td>
                    <td class="price">
                        {{ Helper::createRupiah($item->sales_delivery_detail_price) ?? '' }}
                    </td>
                    <td class="qty">
                        {{ $item->sales_delivery_detail_qty ?? '' }}
                    </td>
                    <td class="total">
                        @if($item->sales_delivery_detail_discount_percent)
                        <span>
                            Disc : {{ $item->sales_delivery_detail_discount_percent }}%
                        </span>
                        <span>
                            - {{ Helper::createRupiah($item->sales_delivery_detail_discount_value) }}
                        </span>
                        @endif
                        {{ Helper::createRupiah($item->sales_delivery_detail_total) ?? '' }}
                    </td>
                </tr>
                @endforeach
                <tr class="total_product">
                    <td class="product" colspan="6">
                        Total Product
                    </td>
                    <td class="qty">
                        {{ $detail->sum('sales_delivery_detail_qty') ?? '' }}
                    </td>
                    <td class="total">
                        {{ Helper::createRupiah($detail->sum('sales_delivery_detail_total')) ?? '' }}
                    </td>
                </tr>
                @if (!empty($master->sales_delivery_discount_percent))
                <tr class="total_discount">
                    <td class="product" colspan="7">
                        {{ $master->sales_delivery_discount_name ?? '' }}
                        Total Discount
                    </td>

                    <td class="total">
                        -{{ Helper::createRupiah($master->sales_delivery_discount_value) ?? '' }}
                    </td>
                </tr>
                @endif
                @if (!empty($master->sales_delivery_tax_percent))
                <tr class="total_discount">
                    <td class="product" colspan="6">
                        {{ $master->tax->finance_tax_name ?? '' }}
                    </td>
                    <td class="qty">
                        {{ $master->sales_delivery_tax_percent ?? '' }}%
                    </td>
                    <td class="total">
                        {{ Helper::createRupiah($master->sales_delivery_tax_value) ?? '' }}
                    </td>
                </tr>
                @endif
                <tr class="total_sumary">
                    <td class="product" colspan="7">
                        Total
                    </td>
                    <td class="total">
                        {{ Helper::createRupiah($master->sales_delivery_sum_total) ?? '' }}
                    </td>
                </tr>

            </table>
        </div>

</body>

</html>