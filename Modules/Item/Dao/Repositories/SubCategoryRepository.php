<?php

namespace Modules\Item\Dao\Repositories;

use Plugin\Notes;
use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Modules\Item\Dao\Models\SubCategory;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Item\Dao\Facades\CategoryFacades;

class SubCategoryRepository extends SubCategory implements MasterInterface
{
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list)->leftJoin(CategoryFacades::getTable(),CategoryFacades::getKeyName(), 'item_sub_category_item_category_id');
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

    public function slugRepository($slug, $relation = false)
    {
        if ($relation) {
            return $this->with($relation)->where('item_category_slug', $slug)->firstOrFail();
        }
        return $this->where('item_category_slug', $slug)->firstOrFail();
    }


    public function showRepository($id, $relation=null)
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
}
