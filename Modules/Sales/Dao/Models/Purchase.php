<?php

namespace Modules\Sales\Dao\Models;

use App\User;
use Plugin\Helper;
use App\Dao\Models\Company;
use Illuminate\Support\Carbon;
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
use Modules\Item\Dao\Models\ProductDetail;
use Modules\Sales\Dao\Models\PurchaseDetail;

class Purchase extends Model
{
    use SoftDeletes;
    protected $table = 'sales_purchase';
    protected $primaryKey = 'sales_purchase_id';
    protected $fillable = [
    'sales_purchase_id',
    'sales_purchase_created_at',
    'sales_purchase_created_by',
    'sales_purchase_updated_at',
    'sales_purchase_updated_by',
    'sales_purchase_deleted_at',
    'sales_purchase_deleted_by',
    'sales_purchase_from_id',
    'sales_purchase_from_name',
    'sales_purchase_from_phone',
    'sales_purchase_from_email',
    'sales_purchase_from_address',
    'sales_purchase_from_area',
    'sales_purchase_to_id',
    'sales_purchase_to_name',
    'sales_purchase_to_phone',
    'sales_purchase_to_email',
    'sales_purchase_to_address',
    'sales_purchase_to_area',
    'sales_purchase_status',
    'sales_purchase_date',
    'sales_purchase_term_top',
    'sales_purchase_term_product',
    'sales_purchase_term_valid',
    'sales_purchase_notes_internal',
    'sales_purchase_notes_external',
    'sales_purchase_discount_name',
    'sales_purchase_discount_percent',
    'sales_purchase_discount_value',
    'sales_purchase_tax_id',
    'sales_purchase_tax_percent',
    'sales_purchase_tax_value',
    'sales_purchase_sum_product',
    'sales_purchase_sum_discount',
    'sales_purchase_sum_tax',
    'sales_purchase_sum_ongkir',
    'sales_purchase_sum_total',
  ];

    public $timestamps = true;
    public $incrementing = false;
    public $rules = [
    'sales_purchase_email' => 'required',
  ];

    public $with = ['detail', 'detail.product'];

    const CREATED_AT = 'sales_purchase_created_at';
    const UPDATED_AT = 'sales_purchase_updated_at';
    const DELETED_AT = 'sales_purchase_deleted_at';

    public $searching = 'sales_purchase_id';
    public $datatable = [
    'sales_purchase_id'                  => [true => 'Code'],
    'sales_purchase_date'                => [true => 'Order Date'],
    'company_contact_name'                => [false => 'Company'],
    'crm_customer_name'                => [true => 'Vendor'],
    'sales_purchase_to_name'                => [false => 'Contact'],
    'sales_purchase_sum_total'                  => [true => 'Total'],
    'sales_purchase_status'                  => [true => 'Status'],
  ];

    protected $dates = [
    'sales_purchase_created_at',
    'sales_purchase_updated_at',
  ];

     protected $casts = [
    'sales_purchase_date' => 'datetime:Y-m-d',
    'sales_purchase_date_purchase' => 'datetime:Y-m-d',
  ];

    public $status = [
    '1' => ['CREATE', 'warning'],
    '2' => ['STOCK', 'primary'],
    '3' => ['TRANSFER', 'success'],
    '0' => ['CANCEL', 'danger'],
  ];

    public $courier = [
    '' => 'Choose Expedition',
    'pos' => 'POS Indonesia (POS)',
    'jne' => 'Jalur Nugraha Ekakurir (JNE)',
    'tiki' => 'Citra Van Titipan Kilat (TIKI)',
    'rpx' => 'RPX Holding (RPX)',
    'wahana' => 'Wahana Prestasi Logistik (WAHANA)',
    'sicepat' => 'SiCepat Express (SICEPAT)',
    'jnt' => 'J&T Express (J&T)',
    'sap' => 'SAP Express (SAP)',
    'jet' => 'JET Express (JET)',
    'indah' => 'Indah Logistic (INDAH)',
    'ninja' => 'Ninja Express (NINJA)',
    'first' => 'First Logistics (FIRST)',
    'lion' => 'Lion Parcel (LION)',
    'rex' => 'Royal Express Indonesia (REX)',
  ];

    public function detail()
    {
        return $this->hasMany(PurchaseDetail::class, 'sales_purchase_detail_order_id', 'sales_purchase_id');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, 'finance_payment_sales_purchase_id', 'sales_purchase_id');
    }

    public function tax()
    {
        return $this->hasOne(Tax::class, 'finance_tax_id', 'sales_purchase_tax_id');
    }

    public function top()
    {
        return $this->hasOne(Top::class, 'finance_top_code', 'sales_purchase_term_top');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'company_id', 'sales_purchase_from_id');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'crm_customer_id', 'sales_purchase_to_id');
    }

    public function Province()
    {
        return $this->hasOne(Province::class, 'rajaongkir_province_id', 'sales_purchase_rajaongkir_province_id');
    }

    public function City()
    {
        return $this->hasOne(City::class, 'rajaongkir_city_id', 'sales_purchase_rajaongkir_city_id');
    }

    public function from()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_purchase_from_id');
    }

    public function to()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_purchase_to_id');
    }

    public function Area()
    {
        return $this->hasOne(Area::class, 'rajaongkir_area_id', 'sales_purchase_rajaongkir_area_id');
    }

    public function forwarder()
    {
        return $this->hasOne(Vendor::class, 'forwarder_vendor_id', 'sales_purchase_forwarder_vendor_id');
    }

    public static function boot()
    {
        parent::boot();
        parent::creating(function ($model) {
            $model->sales_purchase_created_by = auth()->user()->username;
        });

        parent::saving(function ($model) {
            $model->sales_purchase_date = $model->sales_purchase_date->format('Y-m-d H:i:s');        
        });
    }
}
