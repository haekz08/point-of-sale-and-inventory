<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleReturnDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sale_return_id',
        'location_starting_inventory_id',
        'sale_detail_id',
        'product_location_id',
        'qty',
        'price',
        'total',
        'created_by',
        'updated_by',
    ];
    protected $hidden=[
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
