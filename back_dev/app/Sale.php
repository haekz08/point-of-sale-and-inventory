<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FormatterTrait;

class Sale extends Model
{
    use SoftDeletes;
    use FormatterTrait;
    protected $fillable = [
        'transaction_date',
        'order_number',
        'charged_number',
        'sub_total',
        'discount',
        'grand_total',
        'vatable',
        'vat',
        'check_number',
        'remarks',
        'payment_mode_id',
        'sales_rep_id',
        'cashier_id',
        'customer_id',
        'is_payment',
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
        'is_deleted',
    ];
    public function sale_details()
    {
        return $this->hasMany(SaleDetail::class, 'sale_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function sales_rep()
    {
        return $this->belongsTo(Staff::class, 'sales_rep_id', 'id');
    }
    public function cashier()
    {
        return $this->belongsTo(Staff::class, 'cashier_id', 'id');
    }
    public function payment_mode()
    {
        return $this->belongsTo(PaymentMode::class, 'payment_mode_id', 'id');
    }
    public function getTransactionDateAttribute(){
        return $this->format_date($this->attributes['transaction_date']);
    }
    public function getGrandTotalAttribute(){
        return $this->format_amount($this->attributes['grand_total']);
    }
    public function getDiscountAttribute(){
        return $this->format_amount($this->attributes['discount']);
    }
    public function getSubTotalAttribute(){
        return $this->format_amount($this->attributes['sub_total']);
    }
    public function getIsDeletedAttribute(){
        if(!empty($this->attributes['deleted_at']))
            return true;
        return false;
    }
}
