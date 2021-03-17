<?php

namespace Modules\Rajaongkir\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $table = 'rajaongkir_courier';
    protected $primaryKey = 'rajaongkir_courier_code';
    protected $fillable = [
        'rajaongkir_courier_code',
        'rajaongkir_courier_name',
        'rajaongkir_courier_active',
    ];

    public $timestamps = false;
    public $incrementing = false;
    public $rules = [
        'rajaongkir_courier_code' => 'required',
        'rajaongkir_courier_name' => 'required',
    ];

    const CREATED_AT = 'rajaongkir_province_created_at';
    const UPDATED_AT = 'rajaongkir_province_created_by';

    public $searching = 'rajaongkir_courier_name';
    public $datatable = [
        'rajaongkir_courier_code' => [true => 'ID'],
        'rajaongkir_courier_name' => [true => 'Name'],
        'rajaongkir_courier_active' => [true => 'Active'],
    ];

    public function scopeActive($query)
    {
        return $query->where('rajaongkir_courier_active', 1);
    }
}
