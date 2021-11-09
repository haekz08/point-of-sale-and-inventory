<?php

namespace App;

use App\Constants\PaymentModes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FormatterTrait;

class Customer extends Model
{
    use SoftDeletes;
    use FormatterTrait;
    protected $fillable = [
        'name',
        'contact_number',
        'address',
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
        'total_debt',
        'total_payment',
        'total_balance',
    ];

    public function sales_details()
    {
        return $this->hasMany(Sale::class, 'customer_id', 'id');
    }
    public function customer_manual_entries()
    {
        return $this->hasMany(CustomerManualEntries::class, 'customer_id', 'id');
    }
    public function getTotalDebtAttribute()
    {
        return $this->format_amount($this->sales_details->where('payment_mode_id',PaymentModes::CHARGED)->sum('grand_total.default'));
    }
    public function getTotalPaymentAttribute()
    {
        $payment = $this->sales_details->where('is_payment',1)->sum('grand_total.default');
        $discount = $this->sales_details->where('is_payment',1)->sum('discount.default');
        return $this->format_amount($payment+$discount);
    }
    public function getTotalBalanceAttribute()
    {
        $debt = $this->sales_details->where('payment_mode_id',PaymentModes::CHARGED)->sum('grand_total.default');
        $payment = $this->sales_details->where('is_payment',1)->sum('grand_total.default');
        $discount = $this->sales_details->where('is_payment',1)->sum('discount.default');
        $additional_charges = $this->customer_manual_entries->sum('amount.default');
        $balance = ($debt + $additional_charges) - ($payment+$discount);
        return $this->format_amount($balance);
    }
}
