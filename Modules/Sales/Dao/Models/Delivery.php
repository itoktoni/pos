<?php

namespace Modules\Sales\Dao\Models;

use App\Dao\Models\Company;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Crm\Dao\Models\Customer;
use Modules\Sales\Dao\Models\Area;
use Modules\Sales\Dao\Models\DeliveryDetail;
use Modules\Sales\Dao\Models\OrderDetail;

class Delivery extends Model
{
    protected $table = 'sales_delivery';
    protected $primaryKey = 'sales_delivery_id';
    protected $fillable = [
        'sales_delivery_id',
        'sales_delivery_created_at',
        'sales_delivery_created_by',
        'sales_delivery_updated_at',
        'sales_delivery_updated_by',
        'sales_delivery_deleted_at',
        'sales_delivery_deleted_by',
        'sales_delivery_from_id',
        'sales_delivery_from_name',
        'sales_delivery_from_phone',
        'sales_delivery_from_email',
        'sales_delivery_from_address',
        'sales_delivery_from_area',
        'sales_delivery_to_id',
        'sales_delivery_to_name',
        'sales_delivery_to_phone',
        'sales_delivery_to_email',
        'sales_delivery_to_address',
        'sales_delivery_to_area',
        'sales_delivery_status',
        'sales_delivery_date',
        'sales_delivery_date_sync',
        'sales_delivery_term_top',
        'sales_delivery_term_product',
        'sales_delivery_term_valid',
        'sales_delivery_notes_internal',
        'sales_delivery_notes_external',
        'sales_delivery_discount_name',
        'sales_delivery_discount_percent',
        'sales_delivery_discount_value',
        'sales_delivery_tax_id',
        'sales_delivery_tax_percent',
        'sales_delivery_tax_value',
        'sales_delivery_sum_product',
        'sales_delivery_sum_discount',
        'sales_delivery_sum_tax',
        'sales_delivery_sum_ongkir',
        'sales_delivery_sum_total',
    ];

    public $timestamps = true;
    public $incrementing = false;
    protected $keyType = 'string';
    public $rules = [
        'sales_delivery_to_id' => 'required',
    ];

    const CREATED_AT = 'sales_delivery_created_at';
    const UPDATED_AT = 'sales_delivery_updated_at';
    const DELETED_AT = 'sales_delivery_deleted_at';

    public $searching = 'sales_delivery_id';
    public $datatable = [
        'sales_delivery_id' => [true => 'Code'],
        'sales_delivery_date' => [true => 'Order Date'],
        'branch_name' => [true => 'Branch'],
        'sales_delivery_to_name' => [false => 'Contact'],
        'sales_delivery_sum_total' => [true => 'Total'],
        'sales_delivery_status' => [true => 'Status'],
    ];

    // public $with = ['order', 'order_detail', 'customer', 'detail', 'detail.product'];
    public $with = ['detail'];

    protected $dates = [
        'sales_delivery_created_at',
        'sales_delivery_updated_at',
    ];

    protected $casts = [
        'sales_delivery_date' => 'datetime:Y-m-d',
    ];

    public $status = [
        '1' => ['TRANSFER', 'warning'],
        '2' => ['RECEIVED', 'primary'],
        '0' => ['CANCEL', 'danger'],
    ];

    public function detail()
    {
        return $this->hasMany(DeliveryDetail::class, 'sales_delivery_detail_order_id', 'sales_delivery_id');
    }

    public function order_detail()
    {
        return $this->hasMany(OrderDetail::class, 'sales_order_detail_order_id', 'sales_delivery_sales_order_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'company_id', 'sales_delivery_from_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'sales_order_id', 'sales_delivery_sales_order_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'crm_customer_id', 'sales_delivery_to_id');
    }

    public function from()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_delivery_from_id');
    }

    public function to()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_delivery_to_id');
    }

    public static function boot()
    {
        parent::boot();
        parent::creating(function ($model) {
            $model->sales_delivery_created_by = auth()->user()->username;
        });

        parent::saving(function ($model) {
            // $model->sales_delivery_date = $model->sales_delivery_date->format('Y-m-d H:i:s');
        });
    }
}
