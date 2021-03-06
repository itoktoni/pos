<?php

use App\Dao\Facades\BranchFacades;
use App\Dao\Facades\CompanyFacades;
use App\Dao\Models\User as ModelsUser;
use App\User;
use Plugin\Helper;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\DB;
use Modules\Sales\Dao\Models\Area;
use Illuminate\Support\Facades\Hash;
use Modules\Item\Dao\Models\Product;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Dao\Repositories\CompanyRepository;
use App\Dao\Repositories\TeamRepository;
use Illuminate\Validation\ValidationException;
use Modules\Item\Dao\Repositories\StockRepository;
use michaelFrank\dynamicphoto\config\CkeditorUploud;
use Modules\Crm\Dao\Facades\CustomerFacades;
use Modules\Crm\Dao\Repositories\CustomerRepository;
use Modules\Finance\Dao\Repositories\TaxRepository;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Models\ProductDetail;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\VariantRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Rajaongkir\Dao\Facades\AreaFacades;
use Modules\Rajaongkir\Dao\Repositories\PriceRepository;
use Modules\Sales\Dao\Facades\DeliveryFacades;
use Modules\Sales\Dao\Facades\OrderDetailFacades;
use Modules\Sales\Dao\Facades\OrderFacades;
use Modules\Sales\Dao\Models\Delivery;
use Modules\Sales\Dao\Repositories\DeliveryRepository;

// use Helper;
// use Curl;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
//
if (Cache::has('routing')) {
    $cache_query = Cache::get('routing');
    Route::middleware(['auth:api'])->group(function () use ($cache_query) {
        foreach ($cache_query as $route) {
            Route::post($route->action_module, $route->action_path . '@data')->name($route->action_module . '_api');
        }
    });
}
Route::match(
    [
        'GET',
        'POST'
    ],
    'city',
    function () {
        $input = request()->get('q');
        $province = request()->get('province');

        $query = DB::table('rajaongkir_cities');
        if ($province) {
            $query->where('rajaongkir_city_province_id', $province);
        }

        return $query->get();
    }
)->name('city');

Route::match(
    [
        'GET',
        'POST'
    ],
    'location',
    function () {
        $input = request()->get('q');
        $city = request()->get('city');

        $query = DB::table('rajaongkir_areas');
        if ($city) {
            $query->where('rajaongkir_area_city_id', $city);
        }

        return $query->get();
    }
)->name('location');

Route::match(
    [
        'GET',
        'POST'
    ],
    'area',
    function () {
        $input = request()->get('search');
        $query = AreaFacades::where('rajaongkir_area_name', 'like', '%'.$input.'%');
        $query->orWhere('rajaongkir_area_province_name', 'like', '%'.$input.'%');
        $get = $query->orWhere('rajaongkir_area_city_name', 'like', '%'.$input.'%')->get();
        $data = false;
        if ($get->count() > 0) {
            $data = $get->mapWithKeys(function ($item) {
                return [$item['rajaongkir_area_id'] => $item['rajaongkir_area_name'].' - '.$item['rajaongkir_area_type'].' '.$item['rajaongkir_area_city_name'].' - '.$item['rajaongkir_area_province_name']];
            });
        }
        return $data;
    }
)->name('area');

Route::match(
    [
        'GET',
        'POST'
    ],
    'ongkir',
    function () {
        $from = request()->get('from');
        $to = request()->get('to');
        $weight = request()->get('weight');
        $courier = request()->get('courier');
        $branch = request()->get('branch');
        // $curl = curl_init();
        // $key = env('RAJAONGKIR_APIKEY');
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "http://pro.rajaongkir.com/api/cost",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => "origin=$from&originType=subdistrict&destination=$to&destinationType=subdistrict&weight=$weight&courier=$courier",
        //     CURLOPT_HTTPHEADER => array(
        //         "content-type: application/x-www-form-urlencoded",
        //         "key: $key"
        //     ),
        // ));

        // $response = curl_exec($curl);

        // $parse = json_decode($response, true);
        // if (isset($parse)) {
        //     $data = $parse['rajaongkir'];
        //     if ($data['status']['code'] == '200') {
        //         $items = array();
        //         foreach ($data['results'][0]['costs'] as $value) {
        //             $items[] = [
        //                 'id' => $value['cost'][0]['value'],
        //                 'service' => $value['service'],
        //                 'description' => $value['description'],
        //                 'etd' => $value['cost'][0]['etd'],
        //                 'cost' => $value['cost'][0]['value'],
        //                 'price' => number_format($value['cost'][0]['value'])
        //             ];
        //         }
        //     } else {
        //         $items[] = [
        //             'id' => null,
        //             'text' => $data['status']['code'] . ' - ' . $data['status']['description']
        //         ];
        //     }
        // } else {
        //     $items[] = [
        //         'id' => null,
        //         'text' => 'Connection Time Out !'
        //     ];
        // }

        // curl_close($curl);

        // return response()->json($items);

        $response = Curl::to("https://pro.rajaongkir.com/api/cost")->withData([
            'origin' => "$from",
            'originType' => 'subdistrict',
            'destination' => "$to",
            'destinationType' => 'subdistrict',
            'weight' => "$weight",
            'courier' => "$courier",
        ])->withHeaders([
            'key' => env('RAJAONGKIR_APIKEY'),
        ])->post();
    
        $parse = json_decode($response, true);
        $items = false;
        if (isset($parse)) {
            $data = $parse['rajaongkir'];
            if ($data['status']['code'] == '200') {
                $items = array();
                foreach ($data['results'][0]['costs'] as $value) {
                    $items[] = [
                        'branch' => $branch,
                        'weight' => $weight,
                        'courier_code' => $courier,
                        'courier_name' => $data['results'][0]['name'],
                        'courier_service' => $value['service'],
                        'courier_desc' => $value['description'],
                        'courier_etd' => $value['cost'][0]['etd'],
                        'courier_price' => $value['cost'][0]['value'],
                        'courier_mask' => Helper::createRupiah($value['cost'][0]['value']),
                    ];
                }
            }
        }
    
        return json_encode($items);
    }
)->name('ongkir');


Route::match(
    [
        'GET',
        'POST'
    ],
    'waybill',
    function () {
        $waybill = request()->get('waybill');
        $courier = request()->get('courier');
        $request = 'waybill=' . $waybill . '&courier=' . $courier;
        $key = env('RAJAONGKIR_APIKEY');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: $key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
)->name('waybill');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Route::post('/stock', 'PublicController@stock')->name('stock');
// Route::post('team_testing', 'TeamController@data')->middleware('jwt');
// Route::post('team_testing2', 'TeamController@data')->middleware('auth:airlock');

// Route::post('register_api', 'APIController@register');
// Route::post('login_api', 'APIController@login');
// Route::post('air_login', 'APIController@airLogin');

Route::match(
    [
        'GET',
        'POST'
    ],
    'product_api',
    function () {
        $input = request()->get('id');
        $product = new ProductRepository();
        $query = false;
        if ($input) {
            $query = $product->dataRepository()->where($product->getKeyName(), $input)->first();
            return $query->toArray();
        }
        return $query;
    }
)->name('product_api');


Route::match(
    [
        'GET',
        'POST'
    ],
    'sync_product_api/{code}',
    function ($code) {
        $data = request()->get('data');
        ProductDetail::where('item_detail_branch_id', $code)->delete();
        ProductDetail::insert($data);
        return true;
    }
)->name('sync_product_api');


Route::match(
    [
        'GET',
        'POST'
    ],
    'sync_transaction_api',
    function () {
        $data = request()->get('data');
        $detail = request()->get('detail');
        OrderFacades::insert($data);
        OrderDetailFacades::insert($detail);
        return true;
    }
)->name('sync_transaction_api');


Route::match(
    [
        'GET',
        'POST'
    ],
    'delivery_api/{code}',
    function ($code) {
            return DeliveryFacades::where('sales_delivery_status', 1)->where('sales_delivery_to_id', $code)->get();
        return [];
    }
)->name('delivery_api');


Route::match(['GET','POST'],'delivery_get_api/{code}',
    function ($code) {

        $query = new DeliveryRepository();
        if(!empty($code)){
            return $query->with('detail')->find($code);
        }
        return $query->get();
    }
)->name('delivery_get_api');


Route::match(['GET','POST'],'sync_stock/{code}',
    function ($code) {
        $data = request()->get('data');
        // $update = request()->get('update');

        // $from = request()->get('from');
        $to = request()->get('to');

        $code = request()->get('code');
        $date = request()->get('date');

        try {
            
            // DB::beginTransaction();
            Delivery::find($code)->update([
                'sales_delivery_status' => 2,
                'sales_delivery_date_sync' => $date
            ]);
    
            ProductDetail::where('item_detail_branch_id', $to)->delete();
            ProductDetail::create($data);

            // foreach(json_decode($update) as $up){
            //     $upstair = ProductDetail::where('item_detail_branch_id', $from)
            //     ->where('item_detail_product_id', $up['id'])->first();

            //     $upstair->item_detail_stock_qty = $upstair->item_detail_stock_qty - $up['qty'];
            //     $upstair->save();
            // }

            return ['status' => 1];

        } catch (\Throwable $th) {
            return $th->getMessage();
            // DB::rollBack();
        }

        
    }
)->name('sync_stock');


Route::match(
    [
        'GET',
        'POST'
    ],
    'stock_api',
    function () {
        $data = request()->all();
        $username = $data['username'];
        $branch = $data['branch'];

        if(DB::table('users')->where('username', $username)->count() > 0){

            return ProductDetail::where('item_detail_branch_slug', $branch)->get()->mapToGroups(function($model){
                return [$model->item_detail_product_id => $model];
            });
        }
    }
)->name('stock_api');

Route::match(
    [
        'GET',
        'POST'
    ],
    'product_variant_api',
    function () {
        $input = request()->get('id');
        $data = new VariantRepository();
        $query = false;
        if ($input) {
            $query = $data->dataRepository()->where('item_variant_item_product_id', $input);
            return $query->get()->toArray();
        }
        return $query;
    }
)->name('product_variant_api');

Route::match(
    [
        'GET',
        'POST'
    ],
    'variant_api',
    function () {
        $input = request()->get('id');
        $data = new VariantRepository();
        $query = false;
        if ($input) {
            $query = $data->dataRepository()->where($data->getKeyName(), $input);
            return $query->first()->toArray();
        }
        return $query;
    }
)->name('variant_api');


Route::match(
    [
        'GET',
        'POST'
    ],
    'company_api',
    function () {
        $input = request()->get('id');
        $query = false;
        if ($input) {
            $query = CompanyFacades::dataRepository()->where(CompanyFacades::getKeyName(),$input)->first();
            return $query->toArray() ?? false ;
        }
        return $query;
    }
)->name('company_api');

Route::match(
    [
        'GET',
        'POST'
    ],
    'branch_api',
    function () {
        $input = request()->get('id');
        $query = false;
        if ($input) {
            $query = BranchFacades::dataRepository()->where(BranchFacades::getKeyName(),$input)->first();
            return $query->toArray() ?? false ;
        }
        return $query;
    }
)->name('branch_api');

Route::match(
    [
        'GET',
        'POST'
    ],
    'customer_api',
    function () {
        $input = request()->get('id');
        $query = false;
        if ($input) {
            $query = CustomerFacades::dataRepository()->where(CustomerFacades::getKeyName(),$input)->first();
            return $query->toArray() ?? false ;
        }
        return $query;
    }
)->name('customer_api');

Route::match(
    [
        'GET',
        'POST'
    ],
    'user_api',
    function () {
        $input = request()->get('id');
        $query = false;
        if ($input) {
            $user = new TeamRepository();
            $query = $user->dataRepository($user->getKeyName(), $input)->first();
            return $query->toArray() ?? false ;
        }
        return $query;
    }
)->name('user_api');

Route::match(
    [
        'GET',
        'POST'
    ],
    'tax_api',
    function () {
        $input = request()->get('id');
        $query = false;
        if ($input) {
            $query = TaxRepository::find($input);
            return $query->toArray();
        }
        return $query;
    }
)->name('tax_api');


Route::match(
    [
        'GET',
        'POST'
    ],
    'ongkir_api',
    function () {
        $from = request()->get('from');
        $to = request()->get('to');
        $koli = request()->get('koli');
        $paket = request()->get('paket');
        $top = request()->get('top');

        $price = false;
        
        if ($from && $to && $koli && $paket && !empty($top)) {
            $query = new PriceRepository();
            $get = $query->where('rajaongkir_price_from', $from)
            ->where('rajaongkir_price_to', $to)
            ->where('rajaongkir_price_top', $top)
            ->where('rajaongkir_price_paket', $paket)->first();
            if ($get) {
                $price = $koli * $get->rajaongkir_price_value;
            }
        }

        return response()->json([$price]);
    }
)->name('ongkir_api');
