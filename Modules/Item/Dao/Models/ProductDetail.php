<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'item_detail';
    protected $primaryKey = 'item_detail_id';
    protected $fillable = [
        'item_detail_id',
        'item_detail_name',
        'item_detail_stock_enable',
        'item_detail_stock_qty',
        'item_detail_price',
        'item_detail_product_id',
        'item_detail_product_id',
        'item_detail_product_name',
        'item_detail_product_image',
        'item_detail_product_slug',
        'item_detail_product_weight',
        'item_detail_variant_id',
        'item_detail_variant_name',
        'item_detail_color_id',
        'item_detail_color_name',
        'item_detail_size_id',
        'item_detail_size_name',
        'item_detail_branch_id',
        'item_detail_branch_name',
        'item_detail_user_id',
        'item_detail_user_name',
        'item_detail_branch_address',
        'item_detail_branch_province_id',
        'item_detail_branch_province_name',
        'item_detail_branch_city_id',
        'item_detail_branch_city_name',
        'item_detail_branch_area_id',
        'item_detail_branch_area_name',

    ];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
        'item_detail_product_id' => 'required|min:3',
    ];

    const CREATED_AT = 'item_detail_created_at';
    const UPDATED_AT = 'item_detail_created_by';

    public $searching = 'item_detail_file';
    public $datatable = [
        'item_detail_file' => [false => 'ID'],
    ];

    public $status = [
        '1' => ['Active', 'primary'],
        '0' => ['Not Active', 'danger'],
    ];
}
