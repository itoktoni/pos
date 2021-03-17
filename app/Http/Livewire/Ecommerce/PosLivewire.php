<?php

namespace App\Http\Livewire\Ecommerce;

use App\Dao\Facades\BranchFacades;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
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
        '1.jpg' => '5000',
        '2.jpg' => '10000',
        '3.jpg' => '20000',
        '4.jpg' => '50000',
        '5.jpg' => '75000',
        '6.jpg' => '100000',
    ];

    protected $listeners = [
        'updateCart',
    ];

    public function updateCart()
    {

    }

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
                $this->emit('updateCart');
            }
        }
    }

    public function resetBayar()
    {
        Session::remove('bayar');
        $this->emit('updateCart');
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
        $query = ProductFacades::dataRepository()->leftJoin($detail->getTable(), 'item_detail_product_id', ProductFacades::getKeyName());

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
            Cart::add($id, $product->item_product_name, $product->item_product_price, 1, $product->toArray());
        }

        $this->emit('updateCart');
    }

    public function createOrder()
    {
        $this->total = Cart::getTotal();

        $rules = [

            'total' => 'required|numeric|min:1',
        ];

        $this->validate($rules, [
            'checkout.*.branch_ongkir.required' => 'Please Select Courier in Red line',
            'phone.required' => 'Please input phone number in Cart',
            'total.required' => 'Please input name in Cart',
            'address.required' => 'Please input address in Cart',
            'area.required' => 'Please input Shipping area in Cart',
            'total.min' => 'Please Input Shipping area',
        ], [
            'checkout.*.branch_ongkir' => 'Please Select Courier',
        ]);

        $this->completed = true;

        DB::beginTransaction();

        $autonumber_order = Helper::autoNumber(OrderFacades::getTable(), OrderFacades::getKeyName(), config('website.prefix') . date('Ym'), config('website.autonumber'));

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

            Session::forget('checkout');
            Cart::clear();
            Cart::clearCartConditions();
        }

        $this->emit('updateCart');
    }

    public function actionPrint()
    {

    }
}
