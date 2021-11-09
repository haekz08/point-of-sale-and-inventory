<?php

namespace App;

use App\Traits\FormatterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerBalanceLogs extends Model
{
    use SoftDeletes;
    use FormatterTrait;
    protected $fillable = [
        'amount',
        'current_balance',
        'remarks',
        'customer_id',
        'created_by',
        'updated_by',
    ];
    protected $hidden=[
        'created_by',
        'updated_by',
        'updated_at',
        'deleted_at',
    ];

    public function getCreatedAtAttribute(){
        return $this->format_date($this->attributes['created_at']);
    }
    public function getAmountAttribute(){
        return $this->format_amount($this->attributes['amount']);
    }
    public function getCurrentBalanceAttribute(){
        return $this->format_amount($this->attributes['current_balance']);
    }
}
