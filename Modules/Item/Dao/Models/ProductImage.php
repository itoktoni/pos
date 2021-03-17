<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
  protected $table = 'item_product_image';
  protected $primaryKey = 'item_product_image_item_product_id';
  protected $fillable = [
    'item_product_image_item_product_id',
    'item_product_image_file',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_product_image_file' => 'required|min:3',
  ];

  const CREATED_AT = 'item_product_image_created_at';
  const UPDATED_AT = 'item_product_image_created_by';

  public $searching = 'item_product_image_file';
  private static $warehouse;
  public $datatable = [
    'item_product_image_file'          => [false => 'ID'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
