<?php

namespace Modules\Sales\Http\Controllers;

use App\Dao\Repositories\BranchRepository;
use App\Dao\Repositories\CompanyRepository;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Illuminate\Http\Request as Request;
use Ixudra\Curl\Facades\Curl;
use Modules\Crm\Dao\Repositories\CustomerRepository;
use Modules\Finance\Dao\Repositories\PaymentRepository;
use Modules\Finance\Dao\Repositories\TaxRepository;
use Modules\Finance\Dao\Repositories\TopRepository;
use Modules\Item\Dao\Models\ProductDetail;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Marketing\Dao\Repositories\PromoRepository;
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
                foreach ($request->detail as $detail) {
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
                $save = Curl::to(config('website.sync').'api/sync_stock/'.$code)->withData([
                    'code' => $code,
                    'date' => request()->get('sales_delivery_date'),
                    'branch' => $branch,
                    'data' => ProductDetail::where('item_detail_branch_id', $branch)->get(),
                ])->post();

                if($save){
                    Alert::update('Success Syncronize');
                }
            }

        }

        $code = request()->get('code');
        $curl = Curl::to(config('website.sync').'api/delivery_get_api/'.$code)->post();

        $data = json_decode($curl);

        return view(Helper::setViewForm($this->template, 'sync', $this->folder))->with($this->share([
            'model' => $data,
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

    public function transfer(MasterService $service)
    {
        if (request()->isMethod('POST')) {

            $branch = auth()->user()->branch;
            $curl = Curl::to(config('website.sync').'api/delivery_api/'.$branch)->get();
            $data = json_decode($curl);
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
