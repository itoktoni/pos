<?php

namespace Modules\Item\Dao\Models;

use App\Dao\Facades\BranchFacades;
use App\Dao\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Modules\Item\Dao\Facades\ProductFacades;

class ProductDetail extends Model
{
    protected $table = 'item_detail';
    protected $primaryKey = 'item_detail_id';
    protected $fillable = [
        'item_detail_id',
        'item_detail_stock_enable',
        'item_detail_stock_qty',
        'item_detail_branch_id',
    ];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
        'item_detail_product_id' => 'required|min:3',
        'item_detail_branch_id' => 'required',
    ];

    const CREATED_AT = 'item_detail_created_at';
    const UPDATED_AT = 'item_detail_created_by';

    public $searching = 'item_detail_stock_qty';
    public $datatable = [
        'item_detail_file' => [false => 'ID'],
    ];

    public $status = [
        '1' => ['Active', 'primary'],
        '0' => ['Not Active', 'danger'],
    ];

    public $with = ['branch', 'product'];

    public function branch()
    {
        return $this->hasOne(Branch::class, BranchFacades::getKeyName(), 'item_detail_branch_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, ProductFacades::getKeyName(), 'item_detail_product_id');
    }
}
