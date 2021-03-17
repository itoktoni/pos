<?php

namespace App\Http\Controllers;

use App;
use App\Dao\Facades\BranchFacades;
use App\Dao\Repositories\BranchRepository;
use App\Dao\Repositories\TeamRepository;
use Artesaos\SEOTools\Facades\SEOTools;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Darryldecode\Cart\CartCondition;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Ixudra\Curl\Facades\Curl;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Modules\Finance\Dao\Facades\BankFacades;
use Modules\Finance\Dao\Facades\PaymentFacades;
use Modules\Finance\Dao\Repositories\BankRepository;
use Modules\Item\Dao\Facades\CategoryFacades;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Facades\WishlistFacades;
use Modules\Item\Dao\Models\Product;
use Modules\Item\Dao\Repositories\CategoryRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Marketing\Dao\Facades\LanggananFacades;
use Modules\Marketing\Dao\Repositories\ContactRepository;
use Modules\Marketing\Dao\Repositories\HolidayRepository;
use Modules\Marketing\Dao\Repositories\LanggananRepository;
use Modules\Marketing\Dao\Repositories\PageRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Marketing\Dao\Repositories\SliderRepository;
use Modules\Marketing\Dao\Repositories\SosmedRepository;
use Modules\Marketing\Emails\ContactEmail;
use Modules\Rajaongkir\Dao\Repositories\DeliveryRepository;
use Modules\Rajaongkir\Dao\Repositories\ProvinceRepository;
use Modules\Sales\Dao\Facades\OrderFacades;
use Modules\Sales\Dao\Facades\OrderGroupFacades;
use Modules\Sales\Dao\Facades\SubscribeFacades;
use Modules\Sales\Dao\Models\Area;
use Modules\Sales\Dao\Models\City;
use Modules\Sales\Dao\Models\Order;
use Modules\Sales\Dao\Models\OrderTracking;
use Modules\Sales\Dao\Models\Province;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Sales\Dao\Repositories\SubscribeRepository;
use Modules\Sales\Http\Services\LanggananService;
use Modules\Sales\Http\Services\PublicService;
use Plugin\Helper;

class PublicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['account', 'wishlist']);

        SEOTools::setTitle(config('website.name'));
        SEOTools::setDescription(config('website.seo'));
        SEOTools::opengraph()->setUrl(url('/'));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::jsonLd()->addImage(Helper::files('logo/' . config('website.logo')));
    }

    private function share($data = [])
    {
        $sosmed = Helper::createOption(new SosmedRepository(), false, true);
        $category = Helper::createOption(new CategoryRepository(), false, true);
        $product = Helper::createOption(new ProductRepository(), false, true);
        $page = Helper::createOption(new PageRepository(), false, true);
        $view = [
            'gsosmed' => $sosmed,
            'gcategory' => $category,
            'gproduct' => $product,
            'gpage' => $page,
        ];

        return array_merge($view, $data);
    }

    public function index($slug = false)
    {
        if (config('website.application')) {
            return redirect()->route('login');
        }

        // $slider = Helper::createOption(new SliderRepository(), false, true);
        // $promo = Helper::createOption(new PromoRepository(), false, true);
        // $category = Helper::createOption(new categoryRepository(), false, true);
        // $best_sellers = ProductFacades::getBestSeller()->get();
        // $new_product = ProductFacades::getNewProduct()->get();
        // $data_wishlist = [];

        // if (auth()->check()) {

        //     $data_wishlist = WishlistFacades::getUserRepository();
        // }

        // return View(Helper::setViewFrontend('pos'))->with($this->share([
        //     'categories' => $category,
        //     'promos' => $promo,
        //     'sliders' => $slider,
        //     'best_sellers' => $best_sellers,
        //     'new_product' => $new_product,
        //     'data_wishlist' => $data_wishlist,
        // ]));
        if (!auth()->check()) {
            return redirect()->route('login');
        }
            
        return View(Helper::setViewFrontend('pos'));
    }

    public function subscribe(Request $request)
    {
        if (request()->isMethod('POST')) {

            $validator = Validator::make($request->all(), [
                'phone' => 'required|min:8|max:13',
            ]);

            if ($validator->fails()) {
                return redirect('/')->withErrors($validator)->withInput();
            } else {
                session()->flash('success', 'Phone has been saved !');
            }
        }

        return redirect()->to('/');
    }

    public function view($slug)
    {
        $product = ProductFacades::slugRepository($slug);
        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'oproduct' => $product,
        ]);
    }

    public function auth()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function about()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function filters()
    {
        return redirect()->route('shop');
    }

    public function shop($type = null, $slug = null)
    {
        SEOTools::setTitle('Belanja murah di ' . config('website.name'));
        SEOTools::setDescription(config('website.seo'));
        SEOTools::opengraph()->setUrl(route('shop'));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::jsonLd()->addImage(Helper::files('logo/' . config('website.logo')));

        if (request()->has('murah')) {
            $category = CategoryFacades::where('item_category_slug', request()->get('murah'))->first();
            if ($category) {

                SEOTools::setTitle('Belanja ' . $category->item_category_name);
                SEOTools::setDescription($category->item_category_description);
                SEOTools::opengraph()->setUrl(route('category', ['slug' => $category->item_category_slug]));
                SEOTools::opengraph()->addProperty('type', 'articles');
                SEOTools::jsonLd()->addImage(Helper::files('category/' . $category->item_category_image));
            }
        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
        ]));
    }

    public function faq()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with([]);
    }

    public function track($code)
    {
        $waybill = Cache::get('waybill');
        $check_tracking = OrderTracking::where('order_tracking_order_id', 'SO2021020001')->orderByDesc('order_tracking_date')->first();

        $collect = collect($waybill->rajaongkir->result->manifest)->sortDesc()->first();
        dd($collect);
        if ($collect->manifest_date != $check_tracking->order_tracking_date) {
            dd(false);
        }

        dd(true);
        $model = new OrderRepository();
        $data = $model->showRepository($code);
        if ($data) {
            try {
                //code...
                $response = Curl::to(route('waybill'))->withData([
                    'waybill' => $data->sales_order_rajaongkir_waybill,
                    'courier' => $data->sales_order_rajaongkir_courier,
                ])->post();
                $waybill = json_decode($response);
                if (isset($waybill) && !empty($waybill->rajaongkir) && $waybill->rajaongkir->status->code == 200) {
                    return View(Helper::setViewFrontend(__FUNCTION__))->with([
                        'data' => $data,
                        'waybill' => $waybill->rajaongkir->result,
                    ]);
                } else {
                    abort(403, $waybill->rajaongkir->status->description);
                }
            } catch (\Throwable $th) {
                abort(403, 'Ongkir API was down !');
                //throw $th;
            }
        }
    }

    public function profile()
    {
        $user = new TeamRepository;
        $province = Helper::createOption(new ProvinceRepository());

        if (Auth::check()) {
            $data_province = Auth::user()->province;
            $data_city = Auth::user()->city;
            $data_area = Auth::user()->area;

            $data = $user->showRepository(Auth::user()->id);
            $area = Helper::getSingleArea(Auth::user()->area, false, true);
        };

        if (request()->isMethod('POST')) {
            $request = request()->all();
            $validation = [
                'name' => 'required',
                'email' => 'required',
                'address' => 'required',
                'province' => 'required',
                'city' => 'required',
                'area' => 'required',
            ];

            $validate = Validator::make($request, $validation);
            if ($validate->fails()) {
                return redirect()->back()->withInput()->withErrors($validate);
            }
            unset($request['province']);
            unset($request['city']);
            $success = $user->updateRepository(Auth::user()->id, $request);
            $area = Helper::getSingleArea($request['area'], false, true);

            if ($success) {
                session()->flash('info', 'Data Has been saved');
            }

        } else {

            $area = Helper::getSingleArea(Auth::user()->area, false, true);
        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'model' => $data,
            'data_province' => isset($area['province']) ? array_keys($area['province']) : [],
            'data_city' => isset($area['city']) ? array_keys($area['city']) : [],
            'data_area' => isset($area['area']) ? array_keys($area['area']) : [],
            'list_province' => $province,
            'list_city' => $area['city'] ?? [],
            'list_area' => $area['area'] ?? [],
        ]));
    }
    public function register()
    {
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share());
    }

    public function account()
    {
        $order = new OrderRepository();
        $data = $order->dataRepository()->select('*')->where('sales_order_to_phone', auth()->user()->phone)->orderBy('sales_order_date_order', 'DESC')->get();
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'status' => Helper::shareStatus($order->status),
            'order' => $data,
        ]));
    }

    public function wishlist()
    {
        // if(request()->has('remove') && is_numeric(request()->get('remove'))){

        //     $wist = WishlistFacades::find(request()->get('remove'))->delete();
        //     return redirect()->route('wishlist');
        // }

        // $data = WishlistFacades::dataUserRepository()->paginate(config('website.pagination'));
        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'gpage' => Helper::createOption(new PageRepository(), false, true),
        ]);
    }

    public function page($slug = false)
    {
        if ($slug) {
            $page = new PageRepository();
            $data = $page->where('marketing_page_slug', $slug)->first();
            if (!$data) {
                abort(404, 'Page not found !');
            }

            return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
                'data' => $data,
            ]));
        }

        abort(404, 'Page not found !');
    }

    public function slider($slug = false)
    {
        if ($slug) {
            $slider = new SliderRepository();
            $data = $slider->dataRepository()->where('marketing_slider_slug', $slug)->first();
            if (!$data) {
                abort(404, 'Page not found !');
            }

            return View(Helper::setViewFrontend('slider'))->with($this->share([
                'data' => $data,
            ]));
        }

        abort(404, 'Page not found !');
    }

    public function promo($slug = false)
    {
        if ($slug) {
            $model = new PromoRepository();
            $data = $model->slugRepository($slug);

            return View(Helper::setViewFrontend('page_promo'))->with($this->share([
                'data' => $data,
            ]));
        }

        $promo = new PromoRepository();
        $data_promo = $promo->dataRepository()
            ->where('marketing_promo_status', 1)
            ->where('marketing_promo_type', 1)->get();
        $single = $data_promo->where('marketing_promo_default', 1)->first();
        return View(Helper::setViewFrontend(__FUNCTION__))->with([
            'promo' => $data_promo->whereNotIn('marketing_promo_default', [1]),
            'single' => $single,
        ]);
    }

    public function category($slug = false)
    {
        if ($slug) {

            session(['category' => [$slug => $slug]]);
            // $category = new CategoryRepository();
            // $data_category = $category->slugRepository($slug);
            // $color = Helper::createOption(new ColorRepository(), false, true)->pluck('item_color_code');
            // $size = Helper::createOption(new SizeRepository(), false, true)->pluck('item_size_code');
            // $tag = Helper::createOption(new TagRepository(), false, true)->pluck('item_tag_slug');
            // $brand = Helper::createOption(new BrandRepository(), false, true)->pluck('item_brand_slug', 'item_brand_name');

            // $product = ProductRepository::where('item_product_item_category_id', $data_category->item_category_id)->paginate(9);
            // return View(Helper::setViewFrontend('shop'))->with([
            //     'color' => $color,
            //     'size' => $size,
            //     'tag' => $tag,
            //     'brand' => $brand,
            //     'product' => $product,
            // ]);
        }

        return redirect()->route('shop');
    }

    public function cart()
    {
        // Cart::clear();
        if (request()->isMethod('POST')) {
            $request = request()->all();
            // dd($request);

            if (isset($request['code']) && !empty($request['code'])) {
                $code = $request['code'];
                $validate = Validator::make($request, [
                    'code' => 'required|exists:marketing_promo,marketing_promo_code',
                ], [
                    'code.exists' => 'Voucher Not Valid !',
                ]);

                $promo = new PromoRepository();
                $data = $promo->codeRepository(strtoupper($code));

                if ($data) {
                    $value = Cart::getTotal();
                    $matrix = $data->marketing_promo_matrix;
                    if ($matrix) {

                        // validate with minimal
                        $minimal = $data->marketing_promo_minimal;
                        if ($minimal) {
                            if ($minimal > $value) {
                                $validate->getMessageBag()->add('code', 'Minimal value ' . number_format($minimal) . ' !');
                                return redirect()->back()->withErrors($validate);
                            }
                        }

                        $string = str_replace('@value', $value, $matrix);
                        $total = $value;

                        try {
                            $total = Helper::calculate($string);
                        } catch (\Throwable $th) {
                            $total = $value;
                        }

                        $promo = Cart::getConditions()->first();
                        if ($promo) {
                            Cart::removeCartCondition($promo->getName());
                        }
                        $condition = new CartCondition(array(
                            'name' => $data->marketing_promo_code,
                            'type' => $data->marketing_promo_type == 1 ? 'Promo' : 'Voucher',
                            'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                            'value' => -$total,
                            'order' => 1,
                            'attributes' => array( // attributes field is optional
                                'name' => $data->marketing_promo_name,
                            ),
                        ));

                        Cart::condition($condition);
                    }
                } else {
                    $validate->getMessageBag()->add('code', 'Voucher Not Valid !');
                    return redirect()->back()->withErrors($validate)->withInput();
                }

                if ($validate->fails()) {
                    return redirect()->back()->withErrors($validate)->withInput();
                }
            } else {

                $index = $sub = 0;
                if (isset($request['detail'])) {

                    foreach ($request['detail'] as $detail) {

                        $product_id = $detail['temp_product_id'];
                        $product = ProductFacades::find($product_id);

                        if (isset($detail['temp_product_variant'])) {

                            $collection = collect($detail['temp_product_variant']);
                            $qty = $collection->sum(function ($product) {
                                $qty = intval($product['temp_variant_qty']);
                                return $qty;
                            });

                            $detail['temp_product_qty'] = $qty;

                            $attributes = [
                                'detail' => $detail,
                                'variant' => $detail['temp_product_variant'] ?? [],
                            ];

                        } else {

                            $qty = $detail['temp_product_qty'];
                            $detail['temp_product_qty'] = intval($qty);
                            $attributes = [
                                'detail' => $detail,
                                'variant' => [],
                            ];
                        }

                        $sub_total = $qty * $product->item_product_sell;
                        $sub = $sub + $sub_total;

                        $rules = [
                            'detail.temp_product_qty' => 'required|numeric|min:' . $product->item_product_min_order,
                        ];

                        $message = [
                            'detail.temp_product_qty.required' => 'Qty Harus Diisi !',
                            'detail.temp_product_qty.numeric' => 'Qty Harus Angka !',
                            'detail.temp_product_qty.min' => 'Qty Minimal ' . $product->item_product_min_order . ' !',
                        ];

                        $validate = Validator::make($attributes, $rules, $message);
                        if ($validate->fails()) {
                            return redirect()->back()->withErrors($validate)->withInput();
                        }

                        if (Cart::getContent()->contains('id', $product_id)) {
                            Cart::remove($product_id);
                        }

                        Cart::add($product_id, $product->item_product_name, $product->item_product_sell, $qty, $attributes);

                        $index++;
                    }

                    $this->updatePromo();

                } else {

                    $validate = Validator::make($request, [
                        'code' => 'required|exists:marketing_promo,marketing_promo_code',
                    ], [
                        'code.exists' => 'Voucher Not Valid !',
                    ]);
                }

                return redirect()->back()->withErrors($validate)->withInput();
            }
        }

        $carts = Cart::getContent();
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'carts' => $carts,
        ]));
    }

    public function checkout(PublicService $service)
    {
        $area = [];
        // session()->forget('area');
        if (request()->has('token')) {
            $token = request()->get('token');
            $data = OrderFacades::where('sales_order_token', $token)->firstOrFail();
            $pasing = [
                'master' => $data,
                'detail' => $data->detail,
                'banks' => BankFacades::dataRepository()->first(),
            ];
            $pdf = PDF::loadView(Helper::setViewPrint('print_order'), $pasing)->setPaper('A4', 'potrait');
            return $pdf->stream();
        }

        if (request()->isMethod('POST')) {
            $request = request()->all();
            $autonumber = Helper::autoNumber(OrderFacades::getTable(), OrderFacades::getKeyName(), 'SO' . date('Ym'), config('website.autonumber'));

            if (request()->has('sales_order_to_area')) {
                $area_id = request()->get('sales_order_to_area');
                session()->put('area', Helper::getSingleArea($area_id, false, true));
            }

            // if (isset($request['sales_order_to_area'])) {
            //     $area_id = $request['sales_order_to_area'];
            //     $area = Helper::getSingleArea($area_id, false, true);
            // }

            $detail = collect($request['detail'])->map(function ($item) use ($autonumber) {
                $item['sales_order_detail_order_id'] = $autonumber;
                return $item;
            });

            $request = array_merge($request, [
                'detail' => $detail,
            ]);

            $rules = [
                'sales_order_to_name' => 'required',
                'sales_order_to_phone' => 'required',
                'sales_order_to_email' => 'sometimes|email',
                'sales_order_to_address' => 'required',
                'sales_order_to_area' => 'required',
                'sales_order_from_id' => 'required',
                'sales_order_delivery_type' => 'required',
                'sales_order_date_order' => 'required',
            ];

            $message = [
                'sales_order_to_name.required' => 'Nama Customer Harus Diisi',
                'sales_order_to_phone.required' => 'No. Telp Harus Diisi',
                'sales_order_to_address.required' => 'Alamat Harus Diisi',
                // 'sales_order_to_email.required' => 'Email Harus Diisi',
                'sales_order_to_email.email' => 'Email Tidak Valid',
                'sales_order_to_area.required' => 'Area Pengiriman Harus Diisi',
                'sales_order_from_id.required' => 'Lokasi Pickup Harus Diisi',
                'sales_order_delivery_type.required' => 'Metode Pengiriman Harus Diisi',
                'sales_order_date_order.required' => 'Tanggal Pengiriman Harus Diisi',
            ];

            $validate = Validator::make($request, $rules, $message);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput()->with([
                    'area' => $area,
                ]);
            }

            $order = new OrderRepository();
            $check = $service->save($order, $request);
            if (!isset($check['status'])) {
                $validate->errors()->add('field', 'Something is wrong with this field!');
                return redirect()->back()->withErrors($validate)->withInput()->with([
                    'area' => $area,
                ]);
            } else {
                return redirect()->route('checkout', ['token' => $check['data']->sales_order_token->toString()]);
            }
        }

        if (Auth::check()) {
            $area = Helper::getSingleArea(auth()->user()->area, false, true);
        }

        $carts = Cart::getContent();
        $list_province = Helper::createOption(new ProvinceRepository());
        $branch = Helper::createOption(new BranchRepository());
        $user = Auth::user() ?? [];
        $metode = Helper::createOption(new DeliveryRepository());

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'carts' => $carts,
            'list_province' => $list_province,
            'branch' => $branch,
            'user' => $user,
            'area' => $area,
            'metode' => $metode,
        ]));
    }
    public function langganan(LanggananService $service)
    {
        $area = $langganan_data = $carbon = [];

        if (request()->has('token')) {
            $token = request()->get('token');
            $data = SubscribeFacades::where('sales_langganan_token', $token)->firstOrFail();
            $pasing = [
                'master' => $data,
                'detail' => $data->order,
                'banks' => BankFacades::dataRepository()->first(),
            ];
            $pdf = PDF::loadView(Helper::setViewPrint('print_langganan'), $pasing);
            return $pdf->stream();
        }

        if (request()->has('sales_langganan_date_order')) {
            $date = request()->get('sales_langganan_date_order');
            $carbon = Carbon::createFromFormat('Y-m-d', $date);
        }

        if (request()->has('area')) {
            $area_id = request()->get('area');
            $area = Helper::getSingleArea($area_id, false, true);
        }

        if (request()->has('code')) {
            $code = request()->get('code');
            $langganan_data = LanggananFacades::showRepository($code);
        }

        if (request()->isMethod('POST')) {
            $request = request()->all();

            if (request()->has('sales_langganan_to_area')) {
                $area_id = request()->get('sales_langganan_to_area');
                session()->put('area', Helper::getSingleArea($area_id, false, true));
            }

            $rules = [
                'sales_langganan_to_name' => 'required',
                'sales_langganan_to_phone' => 'required',
                'sales_langganan_to_email' => 'sometimes|email',
                'sales_langganan_to_address' => 'required',
                'sales_langganan_from_id' => 'required',
                'sales_langganan_date_order' => 'required',
                'sales_langganan_date_order' => 'required',
                'sales_langganan_marketing_langganan_id' => 'required',
                // 'sales_langganan_discount_code' => 'sometimes|exists:marketing_promo,marketing_promo_code',
            ];

            $message = [
                'sales_langganan_to_name.required' => 'Nama Customer Harus Diisi',
                'sales_langganan_marketing_langganan_id.required' => 'Paket Langganan Harus Diisi',
                'sales_langganan_to_phone.required' => 'No. Telp Harus Diisi',
                'sales_langganan_to_address.required' => 'Alamat Harus Diisi',
                // 'sales_langganan_to_email.required' => 'Email Harus Diisi',
                'sales_langganan_to_email.email' => 'Email Tidak Valid',
                'sales_langganan_from_id.required' => 'Lokasi Pickup Harus Diisi',
                'sales_langganan_date_order.required' => 'Tanggal Pengiriman Harus Diisi',
                'sales_langganan_marketing_langganan_id.required' => 'Paket Berlangganan Harus Diisi',
                // 'sales_langganan_discount_code.exists' => 'Voucher Not Valid !',
            ];

            $validate = Validator::make($request, $rules, $message);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            if (request()->has('pilih')) {
                return redirect()->route('langganan', ['code' => request()->get('sales_langganan_marketing_langganan_id'), 'area' => request()->get('sales_langganan_to_area'), 'date' => $date])->withInput();
            }

            $validasi = [];
            if (isset($request['detail'])) {

                $grand_total = $discount_total = 0;
                $discount_name = null;
                foreach ($request['detail'] as $detail) {
                    $qty = $int = 0;
                    foreach ($detail['product'] as $product) {
                        if (!isset($product['variant'])) {
                            $quantity = intval($product['sales_order_detail_qty']);
                        } else {
                            $quantity = collect($product['variant'])->map(function ($item) {
                                return intval($item['sales_order_detail_variant_qty']);
                            })->sum();
                        }
                        $qty = $qty + intval($quantity);
                    }
                    // $price = $product['sales_order_detail_price'];
                    // $total = ($qty * $price);
                    // $grand_total = $grand_total + $total;
                    // $int++;
                    $validasi[]['qty'] = $qty;
                    // $validasi[]['total'] = $qty;
                }

                // $promo = new PromoRepository();
                // $promo_code = request()->get('sales_langganan_discount_code');
                // $data_promo = $promo->codeRepository(strtoupper($promo_code));

                // if ($data_promo) {
                //     $value = $grand_total;
                //     $matrix = $data_promo->marketing_promo_matrix;
                //     $discount_name = $data_promo->marketing_promo_name;
                //     if ($matrix) {

                //         // validate with minimal
                //         $minimal = $data_promo->marketing_promo_minimal;
                //         if ($minimal) {
                //             if ($minimal > $value) {
                //                 $validate->getMessageBag()->add('sales_langganan_discount_code', 'Minimal value ' . number_format($minimal) . ' !');
                //                 return redirect()->back()->withErrors($validate);
                //             }
                //         }

                //         $string = str_replace('@value', $value, $matrix);
                //         $discount_total = $value;

                //         try {
                //             $discount_total = Helper::calculate($string);
                //         } catch (\Throwable $th) {
                //             $discount_total = $value;
                //         }
                //     }
                // }

                // $request['discount'] = $discount_total;
                // $request['discount_name'] = $discount_name;

                $request['hari'] = $validasi;
                $validate2 = Validator::make($request, ['hari.*.qty' => 'not_in:0']);
                if ($validate2->fails()) {
                    return redirect()->back()->withErrors($validate2)->withInput();
                }

                $repo = new SubscribeRepository();
                $check = $service->save($repo, $request);
                if (isset($check['status']) && $check['status']) {
                    return redirect()->route('langganan', ['token' => $check['data']->sales_langganan_token->toString()]);
                }

            }
        }

        if (Auth::check()) {
            $area = Helper::getSingleArea(auth()->user()->area, false, true);
        }

        $carts = Cart::getContent();
        $list_province = Helper::createOption(new ProvinceRepository());
        $branch = Helper::createOption(new BranchRepository());
        $user = Auth::user() ?? [];
        $metode = Helper::createOption(new DeliveryRepository());
        $langganan = Helper::createOption(new LanggananRepository());
        $product = Helper::createOption(new ProductRepository(), false, true, true)->where('item_product_langganan', 1);
        $holiday = Helper::createOption(new HolidayRepository(), false, true, true)->where('item_product_langganan', 1);

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'carts' => $carts,
            'list_province' => $list_province,
            'branch' => $branch,
            'user' => $user,
            'area' => $area,
            'metode' => $metode,
            'langganan' => $langganan,
            'langganan_data' => $langganan_data,
            'product' => $product,
            'holiday' => $holiday,
        ]));
    }

    public function delete($id)
    {
        if (Cart::getContent()->contains('id', $id)) {

            Cart::remove($id);
            if (Cart::isEmpty()) {
                Cart::clearCartConditions();
            } else {

                $this->updatePromo();
            }

            return redirect()->route('cart');
        }

        return redirect()->route('cart');
    }

    public function add($id)
    {
        if (is_numeric($id)) {
            $product = new ProductRepository();
            $item = $product->showRepository($id);

            $discount = 0;
            if ($item->item_product_discount_type == 1) {
                $discount = $item->item_product_sell * $item->item_product_discount_value;
            } elseif ($item->item_product_discount_type == 2) {
                $discount = $item->item_product_discount_value;
            }

            $additional = [];
            if (json_decode($item->item_product_color_json) && json_decode($item->item_product_size_json)) {
                $additional = [
                    'image' => $item->item_product_image,
                    'color' => 'random',
                    'size' => 'random',
                    'discount' => $discount,
                ];
            }
            Cart::add($item->item_product_id, $item->item_product_name, $item->item_product_sell, 1, [
                'image' => $item->item_product_image,
                'color' => 'random',
                'size' => 'random',
            ]);
        }
        return true;
    }

    public function confirmation()
    {
        $bank = new BankRepository();
        if (request()->isMethod('POST')) {
            $request = request()->all();
            $rules = [
                'payment_person' => 'required',
                'code' => 'required',
                'payment_person' => 'required',
                'payment_phone' => 'required',
                'payment_value' => 'required',
                // 'payment_email' => 'required|email',
                'payment_date' => 'required',
                'files' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];

            $message = [
                'payment_person.required' => 'Nama Pengirim Harus Diisi',
                'payment_value.required' => 'Jumlah Pembayaran Harus Diisi',
                'code.required' => 'No. Order Harus Diisi',
                // 'code.exists' => 'No. Order Tidak',
                'files.required' => 'Bukti Transfer Harus Upload',
            ];

            $validate = Validator::make($request, $rules, $message);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            if (OrderGroupFacades::find($request['code'])) {

                $update = OrderGroupFacades::showRepository($request['code']);
                $check['status'] = false;
                if ($update) {
                    $request['sales_group_payment_person'] = $request['payment_person'];
                    $request['sales_group_payment_value'] = $request['payment_value'];
                    $request['sales_group_payment_phone'] = $request['payment_phone'];
                    $request['sales_group_status'] = 2;
                    $request['sales_group_payment_email'] = $request['payment_email'];
                    $request['sales_group_payment_bank_from'] = $request['payment_bank_from'];
                    $request['sales_group_payment_bank_to'] = $request['payment_bank_to'];
                    $request['sales_group_payment_date'] = $request['payment_date'];
                    $request['sales_group_payment_notes'] = $request['payment_notes'];

                    $payment = [
                        'finance_payment_amount' => $request['payment_value'],
                        'finance_payment_sales_order_id' => $request['code'],
                        'finance_payment_person' => $request['payment_person'],
                        'finance_payment_phone' => $request['payment_phone'],
                        'finance_payment_email' => $request['payment_email'],
                        'finance_payment_date' => $request['payment_date'],
                        'files' => request()->get('files'),
                        'finance_payment_to' => $request['payment_bank_to'],
                        'finance_payment_from' => $request['payment_bank_from'],
                        'finance_payment_note' => $request['payment_notes'],
                        'finance_payment_in_out' => 1,
                        'finance_payment_status' => 0,
                        'finance_payment_created_by' => $request['payment_person'],
                    ];

                    $check = OrderGroupFacades::updateRepository($request['code'], $request);
                    $check = PaymentFacades::saveRepository($payment);
                }

                if ($check['status']) {
                    return redirect()->route('confirmation')->with('success', 'Data has been Success');
                }

            } else {
                $validate->errors()->add('code', 'Nomer Order tidak Terdaftar !');
                return redirect()->back()->withErrors($validate)->withInput();
            }

        }

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'bank' => Helper::shareOption($bank, false, true)->pluck('finance_bank_name', 'finance_bank_name'),
        ]));
    }

    public function branch()
    {
        if (request()->isMethod('POST')) {
            $contact = new ContactRepository();
            $request = request()->all();
            request()->validate($contact->rules);

            $data = $contact->saveRepository($request);
            if ($data['status']) {
                try {
                    Mail::to(config('website.email'))->send(new ContactEmail($data['data']));
                } catch (Exception $e) {
                    return redirect()->back()->withErrors('Email Not Sent');
                }
            }

            return redirect()->back()->withInput();
        }

        $branch = BranchFacades::dataRepository()->get()->sortBy('branch_id');
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'branchs' => $branch,
        ]));
    }

    public function contact()
    {
        if (request()->isMethod('POST')) {
            $contact = new ContactRepository();
            $request = request()->all();
            $error = request()->validate($contact->rules);

            $data = $contact->saveRepository($request);
            if (isset($data['status']) && $data['status']) {
                try {
                    Mail::to(config('website.email'))->send(new ContactEmail($data['data']));
                } catch (Exception $e) {
                    return redirect()->back()->withErrors('Email Not Sent');
                }
            }

            return redirect()->back()->withErrors($error)->withInput();
        }

        $branch = BranchFacades::find(4);
        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'branch' => $branch,
        ]));
    }

    public function install()
    {
        if (request()->isMethod('POST')) {
            $file = DotenvEditor::load('local.env');
            $file->setKey('DB_CONNECTION', request()->get('provider'));
            $file->setKey('DB_HOST', request()->get('host'));
            $file->setKey('DB_DATABASE', request()->get('database'));
            $file->setKey('DB_USERNAME', request()->get('username'));
            $file->setKey('DB_PASSWORD', request()->get('password'));
            $file->save();
            // dd(request()->get('provider'));
            $value = DotenvEditor::getValue('DB_CONNECTION');
            // dd($value);
            $file = DotenvEditor::setKey('DB_CONNECTION', request()->get('provider'));
            $file = DotenvEditor::save();
            // Config::write('database.connections', request()->get('provider'));
            dd(request()->all());
        }
        // rename(base_path('readme.md'), realpath('').'readme.md');
        return View('welcome');
    }

    public function cara_belanja()
    {
        return View('frontend.' . config('website.frontend') . '.pages.cara_belanja');
    }

    public function konfirmasi()
    {
        if (request()->isMethod('POST')) {
            dd(request()->all());
        }
        return View('frontend.' . config('website.frontend') . '.pages.konfirmasi');
    }

    public function oproduct($slug = false)
    {

        $product = ProductFacades::slugRepository($slug);
        $id_product = $product->item_product_id;
        $images = ProductFacades::getImageDetail($id_product);

        if (auth()->check()) {
            $love = WishlistFacades::isLoveProduct($id_product) ? true : false;
        }

        SEOTools::setTitle('Jual ' . $product->item_product_name);
        SEOTools::setDescription($product->item_product_seo);
        SEOTools::opengraph()->setUrl(route('product', ['slug' => $product->item_product_slug]));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::jsonLd()->addImage(Helper::files('product/' . $product->item_product_image));

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'slug' => $slug,
            'oproduct' => $product,
            'images' => $images,
        ]));
    }

    public function product($slug = false)
    {
        // Cart::clear();
        $data_product = new ProductRepository();
        $product = $data_product->slugRepository($slug);
        $product_id = $product->item_product_id;

        if (request()->isMethod('POST')) {

            $request = request()->all();
            $rules = [
                'detail.temp_product_qty' => 'required|numeric|min:' . $product->item_product_min_order,
            ];

            $message = [
                'detail.temp_product_qty.required' => 'Qty Harus Diisi !',
                'detail.temp_product_qty.min' => 'Qty Minimal ' . $product->item_product_min_order . ' !',
                'detail.temp_product_qty.numeric' => 'Qty Harus Angka !',
            ];

            if (request()->exists('variant')) {

                $collection = collect($request['variant']);
                $qty = $collection->sum(function ($product) {
                    $qty = intval($product['temp_variant_qty']);
                    return $qty;
                });

                $variant = $request['variant'];
            } else {

                $qty = $request['detail']['temp_product_qty'];
                $variant = [];
            }

            $request['detail']['temp_product_qty'] = $qty;
            $validate = Validator::make($request, $rules, $message);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            if (Cart::getContent()->contains('id', $product_id)) {
                Cart::remove($product_id);
            }

            $attributes = [
                'detail' => $request['detail'],
                'variant' => $request['variant'] ?? [],
            ];

            Cart::add($product_id, $product->item_product_name, $product->item_product_sell, $qty, $attributes);
            $this->updatePromo();
        }
        // $product->item_product_counter = $product->item_product_counter + 1;
        // $product->save();
        $product_image = $data_product->getImageDetail($product->item_product_id) ?? [];
        $variants = $data_product->variant($product->item_product_id) ?? [];
        SEOTools::setTitle($product->item_product_name . ' by ' . $product->branch_name);
        SEOTools::setDescription($product->item_product_page_seo);
        SEOTools::opengraph()->setUrl(route('product', ['slug' => $product->item_product_slug]));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::jsonLd()->addImage(Helper::files('product/' . $product->item_product_image));

        return View(Helper::setViewFrontend(__FUNCTION__))->with($this->share([
            'oproduct' => $product,
            'variants' => $variants,
            'images' => $product_image,
        ]));
    }

    private function updatePromo($code = null)
    {
        $promo = new PromoRepository();
        $cartPromo = Cart::getConditions()->first();

        if ($cartPromo) {
            if ($code) {

                $data = $promo->codeRepository(strtoupper($code));
            } else {

                $data = $promo->codeRepository(strtoupper($cartPromo->getName()));
            }

            $value = Cart::getSubTotal();
            $matrix = $data->marketing_promo_matrix;
            if ($matrix) {

                $string = str_replace('@value', $value, $matrix);
                $total = $value;

                try {
                    $total = Helper::calculate($string);
                } catch (\Throwable $th) {
                    $total = $value;
                }

                $promo = Cart::getConditions()->first();
                if ($promo) {
                    Cart::removeCartCondition($promo->getName());
                }

                $condition = new CartCondition(array(
                    'name' => $data->marketing_promo_code,
                    'type' => $data->marketing_promo_type == 1 ? 'Promo' : 'Voucher',
                    'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                    'value' => -$total,
                    'order' => 1,
                    'attributes' => array( // attributes field is optional
                        'name' => $data->marketing_promo_name,
                    ),
                ));

                Cart::condition($condition);
            }
        }
    }

    /*
    File upload
     */
    public function dropzone(Request $request)
    {
        if (request()->has('code')) {
            $code = request()->get('code');
            $path = public_path('files/product_detail');
            $photos = request()->file('file');

            for ($i = 0; $i < count($photos); $i++) {
                $photo = $photos[$i];
                $name = sha1(date('YmdHis') . Str::random(30));
                $save_name = $name . '.' . $photo->getClientOriginalExtension();
                $resize_name = 'thumbnail_' . $save_name;

                Image::make($photo)
                    ->resize(250, null, function ($constraints) {
                        $constraints->aspectRatio();
                    })
                    ->save($path . '/' . $resize_name);

                $photo->move($path, $save_name);
                ProductFacades::saveImageDetail($code, $save_name);
            }

            return response()->json(['status' => 1]);
        }
    }

    public function detail($slug)
    {
        if (!empty($slug)) {
            $data = DB::table('products')
                ->select(['products.*', 'category.name as categoryName'])
                ->leftJoin('category', 'category.id', 'products.category_id')
                ->where('products.slug', $slug)->first();
            return View('frontend.' . config('website.frontend') . '.pages.detail')->with([
                'data' => $data,
                'category' => Helper::createOption('category-api'),
                'tag' => Helper::createOption('tag-api'),
            ]);
        }
    }

    public function stock()
    {
        if (request()->has('id')) {
            $id = request()->get('id');
            $stock = DB::table('view_stock_product')->leftJoin((new Product())->getTable(), 'product', 'item_product_id')->where('id', $id)->first();
            if ($stock && $stock->item_product_min > $stock->qty) {
                return 'Stock Only ' . $stock->qty;
            }

            return 0;
        }
    }
}
