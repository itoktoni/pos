<?php

namespace App\Http\Livewire\Ecommerce;

use App\Dao\Facades\BranchFacades;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;
use Chrome;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Item\Dao\Facades\ProductFacades;
use Modules\Item\Dao\Models\ProductDetail;
use Modules\Item\Dao\Repositories\CategoryRepository;
use Modules\Rajaongkir\Dao\Repositories\ProvinceRepository;
use Modules\Sales\Dao\Facades\OrderDetailFacades;
use Modules\Sales\Dao\Facades\OrderFacades;
use Plugin\Helper;
use Ixudra\Curl\Facades\Curl;


class PosLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'simple-bootstrap';

    // public $data_product = [];

    public $search;
    public $sort;
    public $murah;
    public $total;

    protected $queryString = ['murah' => ['except' => '']];

    public $data_tag = [];
    public $data_color = [];
    public $data_size = [];
    public $data_variant = [];
    public $data_category = [];
    public $data_brand = [];
    public $data_province = [];
    public $data_wishlist = [];

    public $data_uang = [
        '500.jpg' => '500',
        '1000.jpg' => '1000',
        '2000.jpg' => '2000',
        '5000.jpg' => '5000',
        '10000.jpg' => '10000',
        '20000.jpg' => '20000',
        '50000.jpg' => '50000',
        // '75000.jpg' => '75000',
        '100000.jpg' => '100000',
    ];

    protected $listeners = [
        'updateProduct',
    ];

    public function updateQty($id, $sign, $qty = 1)
    {
        if (Cart::getContent()->contains('id', $id)) {

            if ($sign == 'add') {
                $formula = [
                    'quantity' => [
                        'relative' => false,
                        'value' => $qty,
                    ],
                ];
            } else {

                $formula = array('quantity' => -$qty);
            }

            $data_qty = Cart::getContent()->get($id)->quantity;

            if ($data_qty == 1) {
                Cart::remove($id);
            } else {

                Cart::update($id, $formula);
                $this->emit('updateProduct');
            }
        }
    }

    public function resetBayar()
    {
        Session::remove('bayar');
        $this->emit('updateProduct');
    }

    public function actionBayar($value)
    {
        if (Session::has('bayar')) {

            $total = Session::get('bayar');
            $value = $total + $value;
        }

        Session::put('bayar', $value);
    }

    public function actionMinus($id)
    {
        $this->updateQty($id, 'min');
    }

    public function mount()
    {
        $this->fill(request()->only('murah'));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updateProduct()
    {
        $detail = new ProductDetail();
        $query = ProductFacades::dataRepository()->leftJoin($detail->getTable(), 'item_detail_product_id', ProductFacades::getKeyName())->where('item_detail_branch_id', auth()->user()->branch);

        if (!empty($this->search)) {
            $query->where('item_product_name', 'like', "%$this->search%");
        }

        if (!empty($this->murah)) {
            $query->where('item_category_slug', $this->murah);
        }

        $query->groupBy('item_product_id');

        if (!empty($this->sort)) {
            if ($this->sort == 'popular') {

                $query->orderByDesc('item_product_counter');
            } else if ($this->sort == 'seller') {

                $query->orderByDesc('item_product_sold');
            } else if ($this->sort == 'date') {

                $query->orderByDesc('item_product_created_at');
            } else if ($this->sort == 'low') {

                $query->orderBy('item_product_price');
            } else if ($this->sort == 'high') {

                $query->orderByDesc('item_product_price');
            } else {

                $query->orderByDesc('item_product_id');
            }
        }

        return $this->data_product = $query->paginate(config('website.pagination'));
    }

    public function render()
    {
        $pro = new ProvinceRepository();
        $this->data_category = Helper::createOption(new CategoryRepository(), false, true);

        $this->updateProduct();

        return View(Helper::setViewLivewire(__CLASS__), [
            'data_product' => $this->updateProduct(),
        ]);
    }

    public function actionCategory($slug)
    {
        if ($slug == 'reset') {
            $this->murah = null;
        } else {
            $this->murah = $slug;
        }
        $this->updateProduct();
    }

    public function actionReset()
    {
        if (Session::has('bayar')) {
            Session::remove('bayar');
        }

        if (Cart::getContent()) {
            Cart::clear();
            Cart::clearCartConditions();
        }

        $this->search = null;
        $this->murah = null;
        $this->resetPage();
        $this->updateProduct();
    }

    public function actionCart($id)
    {
        $product = ProductFacades::find($id);

        if (Cart::getContent()->contains('id', $id)) {
            Cart::update($id, array(
                'quantity' => +1, // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
            ));
        } else {
            Cart::add($id, $product->item_product_name, $product->item_product_sell, 1, $product->toArray());
        }

        $this->emit('updateProduct');
    }

    public function actionLogout(){

        return redirect()->route('logout');
    }

    public function createOrder()
    {
        $this->total = Cart::getTotal();
        $this->completed = true;

        DB::beginTransaction();

        $autonumber_order = Helper::autoNumber(OrderFacades::getTable(), OrderFacades::getKeyName(), config('website.prefix') . date('ym'), config('website.autonumber'));

        $order['sales_order_id'] = $autonumber_order;
        $order['sales_order_status'] = 1;
        $order['sales_order_date_order'] = date('Y-m-d H:i:s');

        if (auth()->check()) {

            $order['sales_order_core_user_id'] = auth()->user()->id;
        }

        $branch = BranchFacades::find(auth()->user()->branch);
        $order['sales_order_from_id'] = $branch->branch_id;
        $order['sales_order_from_name'] = $branch->branch_name;
        $order['sales_order_from_phone'] = Helper::convertPhone($branch->branch_phone);
        $order['sales_order_from_email'] = $branch->branch_email;
        $order['sales_order_from_address'] = $branch->branch_address;
        $order['sales_order_from_area'] = $branch->branch_rajaongkir_area_id;

        $order['sales_order_sum_bayar'] = session('bayar') ?? 0;
        $order['sales_order_sum_kembalian'] = session('bayar') > 0 ? session('bayar') - $this->total : 0;
        $order['sales_order_sum_total'] = $this->total;

        $check_order = OrderFacades::saveRepository($order);

        if (isset($check_order['status']) && $check_order['status']) {

            foreach (Cart::getContent() as $item) {

                $product['sales_order_detail_order_id'] = $autonumber_order;

                $product['sales_order_detail_notes'] = $item->notes;

                $product['sales_order_detail_item_product_detai_id'] = $item->id;
                $product['sales_order_detail_item_product_id'] = $item->id;
                $product['sales_order_detail_item_product_description'] = $item->name;

                $product['sales_order_detail_qty'] = $item->quantity;
                $product['sales_order_detail_price'] = $item->price;
                $product['sales_order_detail_total'] = $item->getPriceSum();

                $check_item = OrderDetailFacades::saveRepository($product);

                $item_detail = ProductDetail::where('item_detail_product_id', $item->id)
                    ->where('item_detail_branch_id', auth()->user()->branch);
                if ($item_detail->get()->count() > 0) {

                    $total_qty = $item_detail->get()->sum('item_detail_stock_qty');
                    $selisih = $total_qty - $item->quantity;

                    $item_detail->delete();

                    $check = ProductDetail::create([
                        'item_detail_stock_qty' => $selisih,
                        'item_detail_branch_id' => auth()->user()->branch,
                        'item_detail_product_id' => $item->id,
                    ]);
                }

                if (isset($check_item['status']) && $check_item['status']) {

                    DB::commit();

                } else {
                    DB::rollBack();
                    $this->completed = false;
                }
            }
        } else {
            DB::rollBack();
            $this->completed = false;
        }

        if ($this->completed) {

            $this->printPos($autonumber_order);
        }

        // $this->emit('updateProduct');
    }

    public function printPos($order_id)
    {
        $branch = BranchFacades::find(auth()->user()->branch);
        // Set params
        $mid = $branch->branch_name;
        $store_name = config('website.name');
        $store_address = $branch->branch_address;
        $store_phone = $branch->branch_phone;
        $transaction_id = $order_id;
       
        // Init printer
        $printer = new ReceiptPrinter();
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        // $printer->setLogo("public/files/logo/test.png");

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, null, null);

        // Add items
        foreach (Cart::getContent() as $item) {
            $printer->addItem(
                $item->name,
                $item->quantity,
                $item->price
            );
        }

        // Calculate total
        // $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        // Set qr code
        // $printer->setQRcode([
        //     'tid' => $transaction_id,
        // ]);

        // Print receipt
        $printer->printReceipt();
        // $printer->printLogo();

        Session::forget('bayar');
        Cart::clear();
        Cart::clearCartConditions();

        $this->emit('updateProduct');

    }

    public function printAntrian()
    {
        $branch = BranchFacades::find(auth()->user()->branch);
        // Set params
        $mid = $branch->branch_name;
        $store_name = config('website.name');
        $store_address = $branch->branch_address;
        $store_phone = $branch->branch_phone;

        
        $autonumber_order = Helper::autoNumber(OrderFacades::getTable(), OrderFacades::getKeyName(), config('website.prefix') . date('ym'), config('website.autonumber'));
        $transaction_id = str_replace(config('website.prefix') . date('ym'), '', $autonumber_order);
       
        // Init printer
        $printer = new ReceiptPrinter();
        $printer->init(
            config('receiptprinter.connector_type'),
            config('receiptprinter.connector_descriptor')
        );

        // $printer->setLogo("public/files/logo/test.png");

        // Set store info
        $printer->setStore($mid, $store_name, $store_address, $store_phone, null, null);

        // Add items
        foreach (Cart::getContent() as $item) {
            $printer->addItem(
                $item->name,
                $item->quantity,
                $item->price
            );
        }

        // Calculate total
        // $printer->calculateSubTotal();
        $printer->calculateGrandTotal();

        // Set transaction ID
        $printer->setTransactionID($transaction_id);

        // Set qr code
        // $printer->setQRcode([
        //     'tid' => $transaction_id,
        // ]);

        // Print receipt
        $printer->printAntrian();
        // $printer->printLogo();
    }

    public function actionSync(){

        return redirect()->route('home');
        $local_product = ProductFacades::with('detail')->get();

        $test_product = Curl::to('https://localhost/kasir/api/stock_api')->withData([
            'branch' => auth()->user()->branch,
            'username' => auth()->user()->username
        ])->post();
        $data_product = json_decode($test_product);

        foreach($data_product as $item){
            $get = $local_product->where('item_product_id', $item->item_product_id)->first();

            if($get){
                $detail = $get->detail;
                foreach($detail as $det){


                }
            }
            else{
                $parse_product = $item;
                ProductFacades::create([
                    'item_product_id' => $parse_product->item_product_id,
                    'item_product_min_stock' => $parse_product->item_product_min_stock,
                    'item_product_price' => $parse_product->item_product_price,
                    'item_product_item_category_id' => $parse_product->item_product_item_category_id,
                    'item_product_name' => $parse_product->item_product_name,
                ]);
            }
        }
        
    }
}
