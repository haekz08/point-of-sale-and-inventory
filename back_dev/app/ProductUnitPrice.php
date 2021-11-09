<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnitPrice extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_unit_id',
        'price_category_id',
        'price',
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

    public function price_category(){
        return $this->belongsTo(PriceCategory::class, 'price_category_id', 'id');
    }
}
