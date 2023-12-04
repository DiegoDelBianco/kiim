<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'color',
        'order',
        'funnel_order',
        'can_init',
        'is_rearranged_default',
        'is_buy_cancel_default',
        'is_customer_default',
        'is_customer_service_default',
        'is_new',
        'is_buy_pending',
        'is_buy',
        'is_deleted',
        'is_paid',
        'is_avaliable_to_cs',
        'is_delivery_keys',
        'is_waiting',
        'rel_basic_view',
        'tenancy_id',
    ];


    public function tenancy()
    {
        return $this->belongsTo(Tenancy::class);
    }

    public function customer_services()
    {
        return $this->hasMany(CustomerService::class);
    }

    public function reason_finishes()
    {
        return $this->hasMany(ReasonFinish::class);
    }

    public function customer_service()
    {
        return $this->belongsTo(CustomerService::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customer_service_stage()
    {
        return $this->belongsTo(Stage::class, 'customer_service_stage_id');
    }

    public static function getList($tenancy_id = false){
        if($tenancy_id){
            $stages = Stage::where('tenancy_id', $tenancy_id)->orderBy('order')->get();
        }else{
            $tenancies = [];
            foreach(Auth::user()->roles as $tenancy){
                $tenancies[] = $tenancy->tenancy_id;
            }

            $stages = Stage::whereIn('tenancy_id', $tenancies)->get();
        }

        $list = [];
        foreach($stages as $stage){
            $key = $stage->id;
            if(isset($list[$stage->name]))
                $key = $stage->id . ',' . $list[$stage->name]['key'];
            $list[$stage->name] = [
                'key'           =>  $key,
                'value'         =>  $stage->name
            ];

            if($stage->is_deleted)
                $list[$stage->name]['is_deleted'] = true;
        }

        return $list;
    }
}
