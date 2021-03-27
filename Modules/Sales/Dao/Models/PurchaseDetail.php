<?php

namespace Modules\Sales\Dao\Models;

use Modules\Item\Dao\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Rajaongkir\Dao\Models\Area;

class PurchaseDetail extends Model
{
  protected $table = 'sales_purchase_detail';
  protected $primaryKey = 'sales_purchase_detail_order_id';
  protected $foreignKey = 'sales_purchase_detail_item_product_id';
  protected $with = ['product'];
  protected $fillable = [
    'sales_purchase_detail_order_id',
    'sales_purchase_detail_notes',
    'sales_purchase_detail_item_product_id',
    'sales_purchase_detail_item_product_description',
    'sales_purchase_detail_item_product_price',
    'sales_purchase_detail_item_product_weight',
    'sales_purchase_detail_qty',
    'sales_purchase_detail_price',
    'sales_purchase_detail_total',
    'sales_purchase_detail_discount_name',
    'sales_purchase_detail_discount_percent',
    'sales_purchase_detail_discount_value',
    'sales_purchase_detail_tax_id',
    'sales_purchase_detail_tax_percent',
    'sales_purchase_detail_tax_value',
  ];

  public $timestamps = false;
  public $incrementing = false;

  public function getForeignKey()
  {
      return $this->foreignKey;
  }

  public function detail()
  {
    return $this->belongsTo(Order::class, 'sales_purchase_detail_sales_id', 'sales_purchase_id');
  }

  public function product()
  {
    return $this->hasOne(Product::class, 'item_product_id', 'sales_purchase_detail_item_product_id');
  }

}
