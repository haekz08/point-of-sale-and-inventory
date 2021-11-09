<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryTransferDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'inventory_transfer_id',
        'location_starting_inventory_id',
        'product_location_id',
        'product_unit_id',
        'base_unit_qty',
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
