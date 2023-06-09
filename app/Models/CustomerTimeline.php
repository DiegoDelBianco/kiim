<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerTimeline extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'event',
        'type',
        'user_id',
        'customer_service_id',
        'customer_id',
        'tenancy_id',
    ];

    // Facilitador para criar uma nova timeline
    public function newTimeline(Customer $customer, $event, $type){


        $this->customer_id = $customer->id;
        $this->event = $event;
        $this->type = $type;
        $this->tenancy_id = $customer->tenancy_id;
        $this->save();

        $customer->customer_timeline_id = $this->id;
        $customer->save();

        return true;

    }

    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/

    /*belongsTo*/
    public function customerService()
    {
        return $this->belongsTo('App\Models\CustomerService');
    }
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }

    /*hasMany*/
    public function notifyUserView()
    {
        return $this->hasMany('App\Models\NotifyUserView');
    }
}
