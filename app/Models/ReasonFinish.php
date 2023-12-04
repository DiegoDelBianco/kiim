<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasonFinish extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'color',
        'order',
        'avaliable_to_basic',
        'avaliable_to_team_manager',
        'avaliable_to_manager',
        'avaliable_to_admin',
        'customer_stage_id',
        'customer_service_stage_id',
        'tenancy_id',
        'confim_buy_date',
        'confim_signature_date',
        'confim_delivery_keys_date',
        'confim_next_contact_date',
        'confim_paid_date',
    ];

    public function customer_stage()
    {
        return $this->belongsTo(Stage::class, 'customer_stage_id');
    }

    public function customer_service_stage()
    {
        return $this->belongsTo(Stage::class, 'customer_service_stage_id');
    }

    public function tenancy()
    {
        return $this->belongsTo(Tenancy::class);
    }

    public function customer_services()
    {
        return $this->hasMany(CustomerService::class);
    }

    public function customer_service()
    {
        return $this->belongsTo(CustomerService::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
