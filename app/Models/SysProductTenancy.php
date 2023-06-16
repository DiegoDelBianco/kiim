<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysProductTenancy extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'sys_product_id',
        'tenancy_id',
        'status',
        'cycle',
        'assas_sub_id',
        'credit_card_number',
        'credit_card_brand',
        'credit_card_token',
        'last_payment',
        'next_payment',
    ];


    public function activeProduct(){
        $this->status = 'active';
        $this->save();
        echo $this->sysProduct->max_users;
        $this->tenancy->max_users = $this->tenancy->max_users + $this->sysProduct->add_users;
        $this->tenancy->max_customers = $this->tenancy->max_customers + $this->sysProduct->add_customers;
        $this->tenancy->max_websites = $this->tenancy->max_websites + $this->sysProduct->add_websites;
        $this->tenancy->save();

        return true;
    }


    public function deactivateProduct(){
        $this->status = 'disabled';
        $this->save();

        $this->tenancy->max_users = $this->tenancy->max_users - $this->sysProduct->add_users;
        $this->tenancy->max_customers = $this->tenancy->max_customers - $this->sysProduct->add_customers;
        $this->tenancy->max_websites = $this->tenancy->max_websites - $this->sysProduct->add_websites;
        $this->tenancy->save();

        return true;
    }

    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/

    /*belongsTo*/
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }
    public function sysProduct()
    {
        return $this->belongsTo('App\Models\SysProduct');
    }
    
    /*hasMany*/
}
