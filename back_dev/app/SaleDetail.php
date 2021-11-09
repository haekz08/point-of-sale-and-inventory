<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sale_id',
        'authorization_code_designation_id',
        'price_type',
        'location_starting_inventory_id',
        'product_location_id',
        'product_unit_id',
        'qty',
        'base_unit_qty',
        'price',
        'total',
        'is_returned',
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

    protected  $appends = [
        'total_purchased_qty',
    ];
    public function product_location(){
        return $this->belongsTo(ProductLocation::class, 'product_location_id', 'id');
    }
    public function product_unit(){
        return $this->belongsTo(ProductUnit::class, 'product_unit_id', 'id');
    }
    public function price_category(){
        return $this->belongsTo(PriceCategory::class, 'price_category_id', 'id');
    }
    public function authorization_code_designation(){
        return $this->belongsTo(AuthorizationCodeDesignation::class, 'authorization_code_designation_id', 'id');
    }
    public function getTotalPurchasedQtyAttribute(){
        return $this->attributes['base_unit_qty'] * $this->attributes['qty'];
    }
    public function sale_return_detail(){
        return $this->belongsTo(SaleReturnDetail::class, 'sale_detail_id', 'id');
    }
}
