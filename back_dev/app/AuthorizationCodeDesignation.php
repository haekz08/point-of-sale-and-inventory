<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthorizationCodeDesignation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'authorization_code_id',
        'staff_id',
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

    public function staff(){
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }

    public function authorization_code(){
        return $this->belongsTo(AuthorizationCode::class, 'authorization_code_id', 'id');
    }
}
