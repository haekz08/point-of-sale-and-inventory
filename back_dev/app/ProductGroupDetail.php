<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGroupDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_group_id',
        'product_id',
        'qty',
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
