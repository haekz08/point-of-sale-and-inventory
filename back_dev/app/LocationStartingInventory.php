<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationStartingInventory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'product_id',
        'product_location_id',
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
    public function product_location(){
        return $this->belongsTo(ProductLocation::class, 'product_location_id', 'id');
    }
}
