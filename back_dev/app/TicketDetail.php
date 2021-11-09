<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'location_starting_inventory_id',
        'authorization_code_designation_id',
        'price_type',
        'product_location_id',
        'ticket_id',
        'product_unit_id',
        'base_unit_qty',
        'price_category_id',
        'price',
        'qty',
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
}
