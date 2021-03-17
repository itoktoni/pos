<?php

namespace App\Http\Livewire\Ecommerce;

use Livewire\Component;
use Modules\Item\Dao\Facades\WishlistFacades;
use Plugin\Helper;
use Livewire\WithPagination;

class WishlistLivewire extends Component
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

    public function getWishlist(){
        
        $query = WishlistFacades::dataUserRepository();
        
        if (!empty($this->search)) {
            $query->where('item_product_name', 'like', "%$this->search%");
        }

        return $this->data_wishlist = $query->paginate(10);
    }

    public function render()
    {
        $wishlist = [];
        if (auth()->check()) {
            $wishlist = $this->getWishlist();
        }

        return View(Helper::setViewLivewire(__CLASS__))->with([
            'data_wishlist' => $wishlist
        ]);
    }

    public function removeWishlist($id)
    {
        $check = WishlistFacades::isLoveProduct($id);
        if ($check) {
            $check->delete();
            $this->getWishlist();
        } 
    }
}
