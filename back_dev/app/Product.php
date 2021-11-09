<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'brand_id',
        'name',
        'code',
        'capital',
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
    public function supplier_products()
    {
        return $this->hasMany(SupplierProduct::class, 'product_id', 'id');
    }
    public function product_units()
    {
        return $this->hasMany(ProductUnit::class, 'product_id', 'id');
    }
    public function location_starting_inventories(){
        return $this->hasMany(LocationStartingInventory::class, 'product_id', 'id');
    }
}
