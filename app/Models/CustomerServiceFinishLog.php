<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerServiceFinishLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_service_id',
        'reason_finish_id',
        'user_id',
        'customer_stage_id',
        'customer_service_stage_id',
        'customer_id',
        'tenancy_id',
    ];
}
