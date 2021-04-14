<?php

namespace Modules\Sales\Http\Controllers;

use App\Dao\Facades\BranchFacades;
use App\Dao\Repositories\BranchRepository;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;
use Modules\Finance\Dao\Repositories\PaymentRepository;
use Modules\Finance\Dao\Repositories\TaxRepository;
use Modules\Finance\Dao\Repositories\TopRepository;
use Modules\Item\Dao\Facades\CategoryFacades;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Models\ProductDetail;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;
use Modules\Sales\Dao\Facades\OrderDetailFacades;
use Modules\Sales\Dao\Facades\OrderFacades;
use Modules\Sales\Dao\Models\Delivery;
use Modules\Sales\Dao\Repositories\DeliveryRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Sales\Http\Requests\DeliveryRequest;
use Modules\Sales\Http\Requests\OrderRequest;
use Modules\Sales\Http\Services\DeliveryService;
use Modules\Sales\Http\Services\OrderService;
use PDF;
use Plugin\Alert;
use Plugin\Helper;
use Plugin\Response;
use Yajra\DataTables\Facades\DataTables;

class DeliveryController extends Controller
{
    public $template;
    public static $model;
    public static $order;
    public $folder;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new DeliveryRepository();
            self::$order = new OrderRepository();
        }
        $this->template = Helper::getTemplate(__CLASS__);
        $this->folder = 'sales';
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $tops = Helper::shareOption((new TopRepository()));
        $product = Helper::shareOption((new ProductRepository()));
        $tax = Helper::shareOption((new TaxRepository()));
        $promo = Helper::shareOption((new PromoRepository()));
        $branch = Helper::shareOption((new BranchRepository()));
        $status = Helper::shareStatus(self::$model->status);

        $from = $to = ['Please Choose Area'];

        $view = [
            'key' => self::$model->getKeyName(),
            'template' => $this->template,
            'tax' => $tax,
            'tops' => $tops,
            'product' => $product,
            'status' => $status,
            'promo' => $promo,
            'from' => $from,
            'to' => $to,
            'branch' => $branch,
        ];

        return array_merge($view, $data);
    }

    public function create(DeliveryService $service, DeliveryRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->save(self::$model, $request->all());
            return Response::redirectBack($data);
        }
        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'model' => self::$model,
        ]));
    }

    public function update(DeliveryService $service, DeliveryRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->update(self::$model, $request->all());
            $data = $request->all();

            if ($request->sales_purchase_status == 2) {

                foreach ($request->detail as $detail) {
                    $product = ProductDetail::where('item_detail_product_id', $detail['sales_purchase_detail_item_product_id'])->first();
                    if ($product) {
                        $qty = $product->item_detail_stock_qty;
                        $product->item_detail_stock_qty = $qty + $detail['sales_purchase_detail_qty'];
                        $product->save();
                    } else {
                        ProductDetail::create([
                            'item_detail_stock_qty' => $detail['sales_purchase_detail_qty'],
                            'item_detail_branch_id' => auth()->user()->branch,
                            'item_detail_product_id' => $detail['sales_purchase_detail_item_product_id'],
                            'item_detail_stock_enable' => 1,
                            'item_detail_status' => null,
                            'item_detail_date_sync' => null,
                        ]);
                    }
                }
                Delivery::find($request->code)->update([
                    'sales_purchase_status' => 3,
                ]);
            }

            return Response::redirectBack($data);
        }

        $data = $service->show(self::$model);
        $from = Helper::getSingleArea($data->sales_purchase_from_area);
        $to = Helper::getSingleArea($data->sales_purchase_to_area);

        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'model' => $data,
            'from' => $from,
            'to' => $to,
            'detail' => $data->detail,
        ]));
    }

    public function order(OrderService $service, OrderRequest $request)
    {
        if (request()->isMethod('POST')) {
            $data = $service->save(self::$order, $request->all());
            return Response::redirectBack($data);
        }

        $data = $service->show(self::$model);
        $from = Helper::getSingleArea($data->sales_purchase_from_area ?? '');
        $to = Helper::getSingleArea($data->sales_purchase_to_area);

        return view(Helper::setViewForm($this->template, __FUNCTION__, $this->folder))->with($this->share([
            'model' => $data,
            'from' => $from,
            'to' => $to,
            'detail' => $data->detail,
        ]));
    }

    public function delete(MasterService $service)
    {
        if (request()->has('code') && request()->has('detail')) {
            $code = request()->get('code');
            $detail = request()->get('detail');
            self::$model->deleteDetailRepository($code, $detail);
        }

        $service->delete(self::$model);
        return Response::redirectBack();
    }

    public function sync(Request $request)
    {
        if (request()->isMethod('POST')) {

            if ($request->sales_delivery_status == 2) {

                $branch = auth()->user()->branch;
                
                $code = request()->get('code');
                $from = request()->get('from');
                $to = request()->get('to');

                foreach ($request->detail as $detail) {

                    $check_product = ProductFacades::find($detail['id']);
                    if (!$check_product) {

                        ProductFacades::create([
                            'item_product_sell' => $detail['price'],
                            'item_product_name' => $detail['name'],
                            'item_product_item_category_id' => $detail['category'],
                        ]);
                    }

                    $check = ProductDetail::where('item_detail_branch_id', $detail['branch'])->where('item_detail_product_id', $detail['id'])->first();
                    if ($check) {

                        $qty = $check->item_detail_stock_qty;
                        $check->item_detail_stock_qty = $qty + $detail['qty'];
                        $check->save();

                    } else {

                        ProductDetail::create([
                            'item_detail_stock_qty' => $detail['qty'],
                            'item_detail_branch_id' => $detail['branch'],
                            'item_detail_product_id' => $detail['id'],
                            'item_detail_date_sync' => date('Y-m-d H:i:s'),
                        ]);
                    }
                }

                $save = Curl::to(config('website.sync') . 'api/sync_stock/' . $code)->withData([
                    'code' => $code,
                    'date' => request()->get('sales_delivery_date'),
                    'from' => $from,
                    'to' => $to,
                    'data' => ProductDetail::where('item_detail_branch_id', $branch)->get()->toArray(),
                ])->post();
                
                $status = json_decode($save);
                if (isset($status) && $status->status) {
                    Alert::update('Success Syncronize');
                }
                else{
                    Alert::error('Gagal Syncron');
                }
            }

        }

        $code = request()->get('code');
        $curl = Curl::to(config('website.sync') . 'api/delivery_get_api/' . $code)->post();

        $data = json_decode($curl);
        $branch = Helper::shareOption((new BranchRepository()),false);
        $from = [$data->sales_delivery_from_id => $branch[$data->sales_delivery_from_id]];
        $to = [$data->sales_delivery_to_id => $branch[$data->sales_delivery_to_id]];

        return view(Helper::setViewForm($this->template, 'sync', $this->folder))->with($this->share([
            'model' => $data,
            'from' => $from,
            'to' => $to,
        ]));
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->setRaw(['sales_delivery_status'])->datatable(self::$model);
            $datatable->editColumn('sales_delivery_status', function ($select) {
                return Helper::createStatus([
                    'value' => $select->sales_delivery_status,
                    'status' => self::$model->status,
                ]);
            });
            $datatable->addColumn('action', Helper::setViewAction($this->template, $this->folder));

            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields' => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function transfer()
    {
        if (request()->isMethod('POST')) {

            $branch = auth()->user()->branch;
            $curl = Curl::to(config('website.sync') . 'api/delivery_api/' . $branch)->post();
            $data = json_decode($curl);

            DB::table('sync')->insert([
                'sync_branch' => auth()->user()->branch,
                'sync_module' => 'transfer',
                'sync_datetime' => date('Y-m-d H:i:s'),
            ]);

            return DataTables::of($data)
                ->addColumn('checkbox', function ($model) {
                    return '<input type="checkbox" name="id[]" value="{{ $model->sales_delivery_id }}">';
                })
                ->addColumn('action', function ($model) {
                    return '<div class="action text-center"><a href="' . route('sync_order_sync') . '?code=' . $model->sales_delivery_id . '" class="btn btn-warning btn-xs">Sync</a></div>';
                })
                ->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields' => [
                'sales_delivery_id' => 'Delivery Code',
                'sales_delivery_date' => 'Delivery Date',
                'sales_delivery_notes_internal' => 'Notes',
                'sales_delivery_sum_total' => 'Total',
            ],
            'template' => $this->template,
        ]);
    }

    private function sync_stock()
    {
        $branch = auth()->user()->branch;
        $product_detail = ProductDetail::setEagerLoads([])->select(['item_detail_stock_qty', 'item_detail_branch_id', 'item_detail_product_id'])->get();
        $curl = Curl::to(config('website.sync') . 'api/sync_product_api/' . $branch)->withData([
            'data' => $product_detail->toArray(),
        ])->post();

        DB::table('sync')->insert([
            'sync_branch' => auth()->user()->branch,
            'sync_module' => 'stock',
            'sync_datetime' => date('Y-m-d H:i:s'),
        ]);

        return $curl;
    }

    public function product()
    {
        if (request()->isMethod('POST')) {

            $request = request()->all();
            if (isset($request['sync'])) {

                $this->sync_stock();
                Alert::update('Success Syncronize');

            } else if (isset($request['pdf'])) {

                $from = $request['from'];
                $to = $request['to'];

                $detail = new ProductDetail();
                $data = DB::table(ProductFacades::getTable())
                ->leftJoin($detail->getTable(), 'item_detail_product_id', ProductFacades::getKeyName())
                ->leftJoin(CategoryFacades::getTable(), CategoryFacades::getKeyName(), 'item_product_item_category_id')
                ->leftJoin(BranchFacades::getTable(), BranchFacades::getKeyName(), 'item_detail_branch_id')
                ->whereNotNull('item_detail_product_id')
                //->where('item_detail_date_sync','>=', $from)
                //->where('item_detail_date_sync','<=', $to)
                ->get();
                
                $id = request()->get('code');
                $pasing = [
                    'data' => $data,
                    'from' => $from,
                    'to' => $to
                ];
                $pdf = PDF::loadView(Helper::setViewPrint('print_stock', $this->folder), $pasing);
                return $pdf->download();
                // return $pdf->stream();
            }
        }

        $product = ProductFacades::with(['detail' => function ($query) {
            $query->where('item_detail_branch_id', '=', auth()->user()->branch);
        }])->get();

        return view(Helper::setViewForm($this->template, 'product', $this->folder))->with([
            'product' => $product,
            'template' => $this->template,
        ]);
    }

    public function transaction()
    {
        $order = OrderFacades::select([
            'sales_order_id',
            'sales_order_date_order',
            'sales_order_from_id',
            'sales_order_from_name',
            'sales_order_from_phone',
            'sales_order_from_email',
            'sales_order_from_address',
            'sales_order_from_area',
            'sales_order_status',
            'sales_order_sum_kembalian',
            'sales_order_sum_bayar',
            'sales_order_sum_total',
            'sales_order_core_user_id',
        ])->setEagerLoads([])->where('sales_order_from_id', auth()->user()->branch)
            ->whereNull('sales_order_date_sync');

        if (request()->isMethod('POST')) {

            $detail = OrderDetailFacades::join(OrderFacades::getTable(), OrderFacades::getKeyName(), 'sales_order_detail_order_id')
                ->setEagerLoads([])
                ->whereNull('sales_order_date_sync')
                ->select([
                    'sales_order_detail_order_id',
                    'sales_order_detail_item_product_detai_id',
                    'sales_order_detail_item_product_id',
                    'sales_order_detail_qty',
                    'sales_order_detail_price',
                    'sales_order_detail_total',
                ]);

            $branch = auth()->user()->branch;
            $curl = Curl::to(config('website.sync') . 'api/sync_transaction_api')
                ->withData([
                    'data' => $order->get()->toArray(),
                    'detail' => $detail->get()->toArray(),
                ])->post();

            $order->update([
                'sales_order_date_sync' => date('Y-m-d H:i:s'),
            ]);

            $detail->update([
                'sales_order_detail_date_sync' => date('Y-m-d H:i:s'),
            ]);

            $this->sync_stock();

            DB::table('sync')->insert([
                'sync_branch' => auth()->user()->branch,
                'sync_module' => 'transaction',
                'sync_datetime' => date('Y-m-d H:i:s'),
            ]);

            Alert::update('Success Syncronize');
        }

        return view(Helper::setViewForm($this->template, 'transaction', $this->folder))->with([
            'order' => $order->whereNull('sales_order_date_sync')->get(),
            'template' => $this->template,
        ]);
    }

    public function show(MasterService $service)
    {
        $data = $service->show(self::$model);
        $field = Helper::listData(self::$model->datatable);
        unset($field['sales_purchase_status']);
        unset($field['rajaongkir_paket_name']);
        unset($field['finance_top_name']);
        $payment = PaymentRepository::where('finance_payment_sales_purchase_id', $data->sales_purchase_id)->get();
        return view(Helper::setViewShow())->with($this->share([
            'fields' => $field,
            'payment' => $payment,
            'model' => $data,
            'key' => self::$model->getKeyName(),
        ]));
    }

    public function print_order(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['detail', 'company']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'detail' => $data->detail,
            ];
            $pdf = PDF::loadView(Helper::setViewPrint('print_delivery', $this->folder), $pasing);
            // return $pdf->download();
            return $pdf->stream();
        }
    }
}
