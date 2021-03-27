<?php

namespace Modules\Sales\Http\Requests;

use Plugin\Helper;
use Modules\Sales\Dao\Models\Purchase;
use Nwidart\Modules\Facades\Module;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Modules\Sales\Dao\Repositories\PurchaseRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Sales\Dao\Models\PurchaseDetail;

class PurchaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    private static $model;

    public function __construct(PurchaseRepository $models)
    {
        self::$model = $models;
    }

    public function prepareForValidation()
    {
        $autonumber = Helper::autoNumber(self::$model->getTable(), self::$model->getKeyName(), 'PO' . date('Ym'), config('website.autonumber'));
        if (!empty($this->code)) {
            $autonumber = $this->code;
        }
        $map = collect($this->detail)->map(function ($item) use ($autonumber) {
            $product = new ProductRepository();
            $data_product = $product->showRepository($item['temp_id'])->first();
            $total = $item['temp_qty'] * Helper::filterInput($item['temp_price']) ?? 0;
            // $discount = Helper::filterInput($item['temp_disc']) ?? 0;
            // $discount_total = $discount * $total / 100;
            $data['sales_purchase_detail_order_id'] = $autonumber;
            $data['sales_purchase_detail_item_product_id'] = $item['temp_id'];
            $data['sales_purchase_detail_item_product_description'] = $item['temp_notes'] ?? '';
            $data['sales_purchase_detail_item_product_price'] = $data_product->item_product_sell ?? '';
            $data['sales_purchase_detail_item_product_weight'] = $data_product->item_product_weight ?? '';
            $data['sales_purchase_detail_qty'] = Helper::filterInput($item['temp_qty']);
            $data['sales_purchase_detail_price'] = Helper::filterInput($item['temp_price']) ?? 0;
            $data['sales_purchase_detail_total'] = $total;
            // $data['sales_purchase_detail_discount_name'] = $item['temp_desc'];
            // $data['sales_purchase_detail_discount_percent'] = Helper::filterInput($item['temp_disc']) ?? 0;
            $data['sales_purchase_detail_discount_value'] = $discount_total ?? 0;
            return $data;
        });

        $this->merge([
            'sales_purchase_id' => $autonumber,
            'sales_purchase_discount_value' => Helper::filterInput($this->sales_purchase_discount_value) ?? 0,
            // 'sales_purchase_tax_value' => Helper::filterInput($this->sales_purchase_tax_value) ?? 0,
            'sales_purchase_sum_product' => Helper::filterInput($this->sales_purchase_sum_product) ?? 0,
            'sales_purchase_sum_discount' => Helper::filterInput($this->sales_purchase_sum_discount) ?? 0,
            // 'sales_purchase_sum_tax' => Helper::filterInput($this->sales_purchase_sum_tax) ?? 0,
            'sales_purchase_sum_total' => Helper::filterInput($this->sales_purchase_sum_total) ?? 0,
            'detail' => array_values($map->toArray()),
            ]);
    }
        
    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'sales_purchase_to_id' => 'required',
                'detail' => 'required',
            ];
        }
        return [];
    }

    public function attributes()
    {
        return [
            'sales_purchase_to_id' => 'Company',
        ];
    }

    public function messages()
    {
        return [
            'detail.required' => 'Please input detail product !'
        ];
    }
}
