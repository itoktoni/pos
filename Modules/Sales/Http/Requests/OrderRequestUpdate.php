<?php

namespace Modules\Sales\Http\Requests;

use App\Http\Services\MasterService;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Plugin\Helper;

class OrderRequestUpdate extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    private static $model;
    private static $service;

    public function __construct(OrderRepository $models, MasterService $services)
    {
        self::$model = $models;
        self::$service = $services;
    }

    public function prepareForValidation()
    {
        $autonumber = Helper::autoNumber(self::$model->getTable(), self::$model->getKeyName(), 'SO' . date('Ym'), config('website.autonumber'));
        if (!empty($this->code)) {
            $autonumber = $this->code;
        }

        $map = collect($this->detail)->map(function ($item) {
            $product = new ProductRepository();
            
            $sent = Helper::filterInput($item['temp_sent']);
            $price = Helper::filterInput($item['temp_price']);
            $total = $sent * $price;
            
            if (Helper::filterInput($item['temp_qty']) < Helper::filterInput($item['temp_sent'])) {
                $sent = Helper::filterInput($item['temp_qty']);
                $total = $sent * $price;
            }

            $data['sales_order_detail_id'] = Helper::filterInput($item['temp_id']);
            $data['sales_order_detail_price'] = Helper::filterInput($item['temp_price']);
            $data['sales_order_detail_total'] = $total;
            $data['sales_order_detail_sent'] = $sent;

            return $data;
        });

        $this->merge([
            'sales_order_id' => $autonumber,
            'sales_order_discount_value' => Helper::filterInput($this->sales_order_discount_value) ?? 0,
            'sales_order_sum_product' => Helper::filterInput($this->sales_order_sum_product) ?? 0,
            'sales_order_sum_total' => Helper::filterInput($this->sales_order_sum_total) ?? 0,
            'sales_order_sum_ongkir' => Helper::filterInput($this->sales_order_sum_ongkir) ?? 0,
            'detail' => array_values($map->toArray()),
        ]);
    }

    public function rules()
    {
        if (request()->isMethod('POST')) {
            return [
                'sales_order_from_id' => 'required',
                'sales_order_from_name' => 'required',
                'detail' => 'required',
            ];
        }
        return [];
    }

    public function attributes()
    {
        return [
            'sales_order_from_id' => 'Company',
        ];
    }

    public function messages()
    {
        return [
            'detail.required' => 'Please input detail product !',
        ];
    }
}
