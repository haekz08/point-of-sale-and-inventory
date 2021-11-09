<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleReturn extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sale_id',
        'credited_sale_id',
        'transaction_date',
        'total',
        'return_type_id',
        'sales_rep_id',
        'cashier_id',
        'is_credited',
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
