<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FormatterTrait;

class Ticket extends Model
{
    use SoftDeletes;
    use FormatterTrait;
    protected $fillable = [
        'sales_rep_id',
        'cashier_id',
        'payment_mode_id',
        'transaction_date',
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

    public function ticket_details()
    {
        return $this->hasMany(TicketDetail::class, 'ticket_id', 'id');
    }
    public function cashier()
    {
        return $this->belongsTo(Staff::class, 'cashier_id', 'id');
    }
    public function sales_rep()
    {
        return $this->belongsTo(Staff::class, 'sales_rep_id', 'id');
    }
    public function payment_mode()
    {
        return $this->belongsTo(PaymentMode::class, 'payment_mode_id', 'id');
    }

    // ALL GETTERS STARTS HERE
    public function getTransactionDateAttribute(){
        return $this->format_date($this->attributes['transaction_date']);
    }
    // ALL GETTERS ENDS HERE
}
