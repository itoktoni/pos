<!DOCTYPE html>
<html>

<style>
h5{
    margin-top: 50px;
}  
</style>
<body>
    <div id='page'>

        <h1 style="text-align:center;">
            <img style="height: 120px;margin:0px auto;" src="{{ Helper::files('logo/'.config('website.logo')) }}"
                alt="{{ config('website.name') }}">
        </h1>
        
        <div style="margin-bottom: 0px;clear: both;width:600px;margin:0px auto;">
            <h2
                style='margin-bottom:20px;padding-top:20px;text-align: center; color:black;line-height: 0; font-weight: bold;'>
                Hai {{ $data->sales_order_to_name ?? '' }}
            </h2>

            <div
                style="color:white;text-align:center;padding:20px;background-color:#{{ config('website.colors') }};border-radius:20px;">
                <h3 style="text-align:center;"> Transaksi {{ $data->sales_order_id ?? '' }} berada di {{ $manifest->city_name ?? '' }}  </h3>
                <h2>Status : {{ $manifest->manifest_code ?? '' }}</h2>
                <p>
                    Notes : {{ str_replace('~~', '',$manifest->manifest_description) ?? '' }}
                </p>
                <a style="background-color:#{{ config('website.color') }};color:white;text-decoration: none;padding:12px 10px;border-radius:20px;margin-top:0px;position:absolute;right:50%;margin-right:-80px;"
                    href="{{ Helper::base_url() }}">Tanggal {{ $manifest->manifest_date ?? '' }}</a>
            </div>

        </div>

        <h5 style="text-align:center !important;">{!! config('website.address') !!}</h5>
    </div>
</body>

</html>