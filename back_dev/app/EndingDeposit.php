<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EndingDeposit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'transaction_date',
        'total',
        'bdq_1',
        'bdq_2',
        'bdq_3',
        'bdq_4',
        'bdq_5',
        'bdq_6',
        'bdq_7',
        'bdq_8',
        'bdq_9',
        'bdq_10',
        'bdq_11',
        'bdq_12',
        'remarks',
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
