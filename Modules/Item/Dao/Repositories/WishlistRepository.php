<?php

namespace Modules\Item\Dao\Repositories;

use Plugin\Helper;
use Plugin\Notes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Item\Dao\Models\Wishlist;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Item\Dao\Facades\BrandFacades;
use Modules\Item\Dao\Facades\CategoryFacades;
use Modules\Item\Dao\Facades\ProductFacades;

class WishlistRepository extends Wishlist implements MasterInterface
{
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list)->addSelect(['item_product.*','item_category_name','item_category_slug' ,'item_brand_name'])
        ->leftJoin(ProductFacades::getTable(), ProductFacades::getKeyName(),'item_wishlist_item_product_id')
        ->leftJoin(CategoryFacades::getTable(), CategoryFacades::getKeyName(),'item_product_item_category_id')
        ->leftJoin(BrandFacades::getTable(), BrandFacades::getKeyName(),'item_product_item_brand_id');
    }

    public function dataUserRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list)->addSelect(['item_product.*','item_category_name','item_category_slug' ,'item_brand_name'])
        ->leftJoin(ProductFacades::getTable(), ProductFacades::getKeyName(),'item_wishlist_item_product_id')
        ->leftJoin(CategoryFacades::getTable(), CategoryFacades::getKeyName(),'item_product_item_category_id')
        ->leftJoin(BrandFacades::getTable(), BrandFacades::getKeyName(),'item_product_item_brand_id')
        ->where('item_wishlist_user_id', Auth::user()->id)  ;
    }

    public function saveRepository($request)
    {
        try {
            $activity = $this->create($request);
            return Notes::create($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function updateRepository($id, $request)
    {
        try {
            $activity = $this->findOrFail($id)->update($request);
            return Notes::update($activity);
        } catch (QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function deleteRepository($data)
    {
        try {
            $activity = $this->Destroy(array_values($data));
            return Notes::delete($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function getUserRepository()
    {
        return $this->select('item_wishlist_item_product_id')->where('item_wishlist_user_id', Auth::user()->id)->get()->pluck('item_wishlist_item_product_id','item_wishlist_item_product_id')->all();
    }

    public function showRepository($id, $relation = false)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }

    public function getDataIn($in)
    {
        return $this->whereIn($this->getKeyName(), $in)->get();
    }

    public function isLoveProduct($product_id){

        if(auth()->check()){

            return $this->where('item_wishlist_item_product_id', $product_id)->where('item_wishlist_user_id', auth()->user()->id)->first();
        }

        return null;
    }
}
