<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Item\Dao\Facades\BrandFacades;
use Modules\Item\Dao\Facades\CategoryFacades;
use Plugin\Helper;
use Illuminate\Support\Str;

class Product extends Model
{
    // use SoftDeletes;
    protected $table = 'item_product';
    protected $branch = 'item_branch_id';
    protected $primaryKey = 'item_product_id';
    protected $fillable = [
        'item_product_id',
        'item_product_slug',
        'item_product_min_stock',
        'item_product_max_stock',
        'item_product_min_order',
        'item_product_max_order',
        'item_product_sku',
        'item_product_buy',
        'item_product_image',
        'item_product_sell',
        'item_product_price',
        'item_product_stroke',
        'item_product_item_category_id',
        'item_product_item_brand_id',
        'item_product_item_material_id',
        'item_product_item_unit_id',
        'item_product_branch_id',
        'item_product_item_tag_json',
        'item_product_item_tax_id',
        'item_product_item_currency_id',
        'item_product_name',
        'item_product_description',
        'item_product_updated_at',
        'item_product_created_at',
        'item_product_deleted_at',
        'item_product_updated_by',
        'item_product_created_by',
        'item_product_counter',
        'item_product_status',
        'item_product_weight',
        'item_product_group',
        'item_product_stock',
        'item_product_display',
        'item_product_langganan',
        'item_product_flag_name',
        'item_product_flag_color',
        'item_product_flag_background',
        'item_product_page_name_1',
        'item_product_page_name_2',
        'item_product_page_name_3',
        'item_product_page_content_1',
        'item_product_page_content_2',
        'item_product_page_content_3',
        'item_product_page_active_1',
        'item_product_page_active_2',
        'item_product_page_active_3',
        'item_product_page_seo',
        'item_product_sold',
        'item_product_is_variant',
    ];

    public $timestamps = true;
    public $incrementing = true;
    public $keyType = 'string';
    public $rules = [
        'item_product_id' => 'required|unique:item_product',
        'item_product_name' => 'required|min:3|unique:item_product',
        'item_product_buy' => 'required',
        'item_product_sell' => 'required',
    ];

    public $with = ['category'];

    const CREATED_AT = 'item_product_created_at';
    const UPDATED_AT = 'item_product_updated_at';
    const DELETED_AT = 'item_product_deleted_at';

    public $searching = 'item_product_name';
    public $datatable = [
        'item_product_id' => [true => 'ID'],
        'item_product_item_category_id' => [false => 'Category'],
        'item_category_name' => [true => 'Category'],
        'item_product_name' => [true => 'Product Name'],
        'branch_name' => [false => 'Branch'],
        'item_category_slug' => [false => 'Category'],
        'item_category_description' => [false => 'Category'],
        'item_product_buy' => [false => 'Buy'],
        'item_product_sell' => [true => 'Harga'],
        'item_product_image' => [false => 'Images'],
        'item_product_slug' => [false => 'Slug'],
        'item_detail_stock_qty' => [true => 'Stock'],
        'item_product_description' => [false => 'Description'],
        'item_product_created_at' => [false => 'Created At'],
        'item_product_created_by' => [false => 'Updated At'],
        'branch_id' => [false => 'Branch'],
    ];

    public $status = [
        '1' => ['Active', 'primary'],
        '0' => ['Not Active', 'danger'],
    ];

    public $promo = [
        '0' => ['Not Active', 'danger'],
        '1' => ['Percent', 'primary'],
        '2' => ['Amount', 'success'],
    ];

    protected $casts = [
        'item_product_sell' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        $statis = 'data';
        parent::creating(function ($model) {
            // if(empty($model->item_product_id)){

            //     $model->item_product_id = Helper::autoNumber($model->getTable(), 'item_product_id', 'P' . date('ymd'), config('website.autonumbers'));
            // }
            // $model->item_product_code = Helper::autoNumber($model->getTable(), 'item_product_id', date('m'), 4);
            
            // if($model->item_product_is_variant == 0){

            //     $data = [
            //         'item_detail_product_id' => request()->get(''),
            //         'item_detail_variant_id' => request()->get(''),
            //         'item_detail_color_id' => request()->get(''),
            //         'item_detail_size_id' => request()->get(''),
            //         'item_detail_branch_id' => request()->get(''),
            //         'item_detail_product_name' => request()->get(''),
            //         'item_detail_variant_name' => request()->get(''),
            //         'item_detail_color_name' => request()->get(''),
            //         'item_detail_size_name' => request()->get(''),
            //         'item_detail_branch_name' => request()->get(''),
            //         'item_detail_price' => request()->get(''),
            //         'item_detail_name' => request()->get(''),

            //     ];
            // }
        });

        parent::saving(function ($model) {

            $file = 'item_product_file';
            if (request()->has($file)) {
                $image = $model->item_product_image;
                if ($image) {
                    Helper::removeImage($image, Helper::getTemplate(__CLASS__));
                }

                $file = request()->file($file);
                $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__), 400, 550);
                $model->item_product_image = $name;
            }

            // if ($model->item_product_min_order <= 0) {
            //     $model->item_product_min_order = 1;
            // }

            // if (request()->has('item_product_item_tag_json')) {
            //     $model->item_product_item_tag_json = json_encode(request()->get('item_product_item_tag_json'));
            // }

            if ($model->item_product_name && empty($model->item_product_slug)) {
                $model->item_product_slug = Str::slug($model->item_product_name);
            } else {
                $model->item_product_slug = Str::slug($model->item_product_slug);
            }

            // $model->item_product_branch_id = auth()->check() ? auth()->user()->branch : '';

        });

        // parent::deleting(function ($model) {
        //     if (request()->has('id')) {
        //         $data = $model->whereIn($model->getkeyName(), request()->get('id'))->get();
        //         if ($data) {
        //             foreach ($data as $value) {
        //                 if ($value->item_product_image) {
        //                     Helper::removeImage($value->item_product_image, Helper::getTemplate(__CLASS__));
        //                 }
        //             }
        //         }
        //     }
        // });
    }

    public function category()
    {
        return $this->hasOne(Category::class, CategoryFacades::getKeyName(), 'item_product_item_category_id');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, BrandFacades::getKeyName(), 'item_product_item_brand_id');
    }

    public function variant($product)
    {
        return $this->join('item_product_variant', 'item_detail_product_id', 'item_product_id')
            ->join('item_variant', 'item_variant_id', 'item_detail_variant_id')->whereColumn('item_detail_product_id', 'item_product_id')->whereColumn('item_detail_variant_id', 'item_variant_id')->where('item_product_id', $product)->get();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'item_product_id', 'item_product_image_item_product_id');
    }

    public function detail()
    {
        return $this->hasMany(ProductDetail::class, 'item_detail_product_id', 'item_product_id');
    }
}
