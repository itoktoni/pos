<?php

namespace Modules\Marketing\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    protected $table = 'marketing_subscribe';
    protected $primaryKey = 'marketing_subscribe_id';
    protected $fillable = [
        'marketing_subscribe_id',
        'marketing_subscribe_phone',
        'marketing_subscribe_description',
    ];

    public $timestamps = false;
    public $incrementing = true;
    public $rules = [
        'marketing_subscribe_phone' => 'required|min:3',
    ];

    const CREATED_AT = 'marketing_subscribe_created_at';
    const UPDATED_AT = 'marketing_subscribe_updated_at';

    public $searching = 'marketing_subscribe_name';
    public $datatable = [
        'marketing_subscribe_id' => [false => 'ID'],
        'marketing_subscribe_phone' => [true => 'Name'],
        'marketing_subscribe_description' => [true => 'Description'],
    ];

    public $status = [
        '1' => ['Active', 'primary'],
        '0' => ['Not Active', 'danger'],
    ];
}
