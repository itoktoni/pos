<?php

namespace Modules\Sales\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTracking extends Model
{
  protected $table = 'sales_tracking';
  protected $primaryKey = 'order_tracking_id';
  protected $fillable = [
    'order_tracking_id',
    'order_tracking_date',
    'order_tracking_location',
    'order_tracking_order_id',
    'order_tracking_description',
  ];

  public $timestamps = false;
  public $incrementing = true;
  public $rules = [
    'order_tracking_description' => 'required',
  ];

  const CREATED_AT = 'order_tracking_created_at';
  const UPDATED_AT = 'order_tracking_created_by';

  public $searching = 'order_tracking_name';
  public $datatable = [
    'order_tracking_id'          => [true => 'Code'],
    'order_tracking_date'        => [true => 'Name'],
    'order_tracking_order_id'        => [true => 'Estimasi Hari'],
    'order_tracking_description'        => [true => 'Description'],
  ];
}
