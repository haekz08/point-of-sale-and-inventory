<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnit extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'unit_id',
        'product_id',
        'base_unit_qty',
        'is_base_unit',
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


    public function product_unit_prices()
    {
        return $this->hasMany(ProductUnitPrice::class, 'product_unit_id', 'id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


    // ALL GETTERS STARTS HERE
    public function getIsBaseUnitAttribute(){
        if($this->attributes['is_base_unit'] == 0)
            return false;
        return true;
    }
    // ALL GETTERS ENDS HERE



    // ALL SETTERS STARTS HERE
    public function setIsBaseUnitAttribute($value){
        if($value == "true"){
            $this->attributes['is_base_unit'] = 1;
        }else{
            $this->attributes['is_base_unit'] = 0;
        }
    }
    // ALL SETTERS ENDS HERE
}
