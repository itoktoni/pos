<?php

namespace Modules\Sales\Dao\Models;

use App\User;
use App\Dao\Models\Company;
use Illuminate\Support\Str;
use Modules\Sales\Dao\Models\Area;
use Modules\Sales\Dao\Models\City;
use Modules\Finance\Dao\Models\Tax;
use Modules\Finance\Dao\Models\Top;
use Illuminate\Support\Facades\Auth;
use Modules\Crm\Dao\Models\Customer;
use Modules\Sales\Dao\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Modules\Finance\Dao\Models\Payment;
use Modules\Forwarder\Dao\Models\Vendor;
use Modules\Sales\Dao\Models\OrderDetail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Sales\Dao\Facades\OrderGroupFacades;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'sales_order';
    protected $primaryKey = 'sales_order_id';
    protected $fillable = [
        'sales_order_id',
        'sales_order_group_id',
        'sales_order_created_at',
        'sales_order_created_by',
        'sales_order_updated_at',
        'sales_order_updated_by',
        'sales_order_deleted_at',
        'sales_order_deleted_by',
        'sales_order_date_order',
        'sales_order_date_wa_completed_wa',
        'sales_order_date_wa_delivered_wa',
        'sales_order_date_wa_processed_wa',
        'sales_order_date_wa_approved_wa',
        'sales_order_date_email_approved_order',
        'sales_order_date_email_track_order',
        'sales_order_from_id',
        'sales_order_from_name',
        'sales_order_from_phone',
        'sales_order_from_email',
        'sales_order_from_address',
        'sales_order_from_area',
        'sales_order_to_id',
        'sales_order_to_name',
        'sales_order_to_phone',
        'sales_order_to_email',
        'sales_order_to_address',
        'sales_order_to_area',
        'sales_order_status',
        'sales_order_notes_user',
        'sales_order_notes_admin',
        'sales_order_discount_code',
        'sales_order_discount_name',
        'sales_order_discount_value',
        'sales_order_sum_product',
        'sales_order_sum_discount',
        'sales_order_sum_ongkir',
        'sales_order_sum_weight',
        'sales_order_sum_total',
        'sales_order_payment_date',
        'sales_order_payment_bank_from',
        'sales_order_payment_bank_to_id',
        'sales_order_payment_person',
        'sales_order_payment_phone',
        'sales_order_payment_email',
        'sales_order_payment_file',
        'sales_order_payment_value',
        'sales_order_payment_notes',
        'sales_order_core_user_id',
        'sales_order_courier_code',
        'sales_order_courier_name',
        'sales_order_courier_service',
        'sales_order_courier_waybill',
        'sales_order_courier_date',
    ];

    public $timestamps = true;
    public $incrementing = false;
    public $rules = [
        'sales_order_to_phone' => 'required',
    ];

    public $with = ['detail', 'detail.product'];

    const CREATED_AT = 'sales_order_created_at';
    const UPDATED_AT = 'sales_order_updated_at';
    const DELETED_AT = 'sales_order_deleted_at';

    public $searching = 'sales_order_id';
    public $datatable = [
        'sales_order_id' => [true => 'Code'],
        'sales_order_created_at' => [false => 'Delivery Date'],
        'sales_order_date_order' => [true => 'Tgl Order'],
        'crm_customer_name' => [false => 'Customer'],
        'sales_order_from_id' => [false => 'Branch'],
        'sales_order_from_name' => [true => 'Branch'],
        'sales_order_sum_total' => [false => 'Branch'],
        'sales_order_sum_ongkir' => [false => 'Branch'],
        'sales_order_sum_product' => [false => 'Branch'],
        'sales_order_courier_waybill' => [false => 'Customer'],
        'sales_order_courier_date' => [false => 'Customer'],
        'sales_order_to_name' => [true => 'Customer'],
        'sales_order_to_phone' => [true => 'Phone'],
        'sales_order_status' => [true => 'Status'],
    ];

    protected $dates = [
        'sales_order_created_at',
        'sales_order_updated_at',
    ];

    protected $casts = [
        'sales_order_date_order' => 'datetime:Y-m-d',
        'sales_order_payment_date' => 'datetime:Y-m-d',
    ];

    public $status = [
        '1' => ['CREATE', 'warning'],
        '2' => ['CONFIRM', 'primary'],
        '3' => ['PAID', 'success'],
        '4' => ['PROCESSED', 'danger'],
        '5' => ['DELIVERED', 'info'],
        '6' => ['COMPLETED', 'default'],
        '0' => ['CANCEL', 'danger'],
    ];

    public function group()
    {
        return $this->hasOne(OrderGroup::class, 'sales_group_id', 'sales_order_group_id');
    }

    public function detail()
    {
        return $this->hasMany(OrderDetail::class, 'sales_order_detail_order_id', 'sales_order_id');
    }

    public function track()
    {
        return $this->hasMany(OrderTracking::class, 'order_tracking_order_id', 'sales_order_id');
    }

    public function delivery()
    {
        return $this->hasMany(DeliveryDetail::class, 'sales_delivery_detail_order_id', 'sales_order_id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, 'finance_payment_sales_order_id', 'sales_order_id');
    }

    public function tax()
    {
        return $this->hasOne(Tax::class, 'finance_tax_id', 'sales_order_tax_id');
    }

    public function top()
    {
        return $this->hasOne(Top::class, 'finance_top_code', 'sales_order_term_top');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'company_id', 'sales_order_from_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'crm_customer_id', 'sales_order_to_id');
    }

    public function Province()
    {
        return $this->hasOne(Province::class, 'rajaongkir_province_id', 'sales_order_rajaongkir_province_id');
    }

    public function City()
    {
        return $this->hasOne(City::class, 'rajaongkir_city_id', 'sales_order_rajaongkir_city_id');
    }

    public function from()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_order_from_id');
    }

    public function to()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_order_to_id');
    }

    public function Area()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_order_rajaongkir_area_id');
    }

    public function forwarder()
    {
        return $this->hasOne(Vendor::class, 'forwarder_vendor_id', 'sales_order_forwarder_vendor_id');
    }

    public static function boot()
    {
        parent::boot();
        parent::creating(function ($model) {
            // $model->sales_order_created_by = auth()->user()->username ?? '';
            // $model->sales_order_token = Str::uuid();
        });

        parent::saving(function ($model) {
            if(request()->has('sales_order_date_order')){
                $model->sales_order_date_order = $model->sales_order_date_order->format('Y-m-d H:i:s');
            }
        });
    }
}