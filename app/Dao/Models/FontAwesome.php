<?php

namespace App\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class FontAwesome extends Model
{
    protected $table = 'core_font_awesome';
    protected $primaryKey = 'font_awesome_code';
    protected $fillable = [
        'font_awesome_code',
        'font_awesome_name',
        'font_awesome_description',
    ];

    public $timestamps = false;

    public $incrementing = false;
    public $rules = [
        'font_awesome_name' => 'required',
    ];

    public $searching = 'font_awesome_name';

    public $datatable = [
        'font_awesome_code'           => [true    => 'Code'],
        'font_awesome_name'           => [true    => 'Name'],
        'font_awesome_description'           => [true    => 'Description'],
    ];

    public $status    = [
        '1' => ['Show', 'info'],
        '0' => ['Hide', 'default'],
    ];
}
