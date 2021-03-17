<?php

namespace App\Http\Livewire\Ecommerce;

use Livewire\Component;
use Modules\Item\Dao\Facades\WishlistFacades;
use Plugin\Helper;
use Livewire\WithPagination;
use Modules\Sales\Dao\Facades\OrderFacades;
use Modules\Sales\Dao\Models\Order;

class AccountLivewire extends Component
{
    use WithPagination;

    public $love = false;
    public $product_id;
    public $search;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getOrder(){
        
        $query = OrderFacades::dataRepository();
        
        if (!empty($this->search)) {
            $query->where('sales_order_id', 'like', "%$this->search%");
            $query->Orwhere('sales_order_from_name', 'like', "%$this->search%");
            $query->Orwhere('sales_order_from_name', 'like', "%$this->search%");
        }

        if(auth()->check()){
            $query->where('sales_order_core_user_id', auth()->user()->id);
        }

        return $query->paginate(3);
    }

    public function render()
    {
        $order = [];
        if (auth()->check()) {
            $order = $this->getOrder();
        }

        $model = new Order();
        return View(Helper::setViewLivewire(__CLASS__))->with([
            'data_order' => $order,
            'status' => Helper::shareStatus($model->status)
        ]);
    }

}
