<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenancy extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'subdomain',
        'name',
        'active',
        'logo',
        'max_users',
        'max_websites',
        'max_customers',
        'user_id',
        'doc',
        'email',
        'phone',
        'cep',
        'address',
        'address_number',
        'complement',
        'province',
        'city',
        'uf',
        'assas_id',
    ];

    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/
    public function sysProducts()
    {
        return $this->belongsToMany('App\Models\SysProduct', 'sys_product_tenancies');
    }

    /*belongsTo*/
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    /*hasMany*/
    public function sysProductTenancy()
    {
        return $this->hasMany('App\Models\SysProductTenancy');
    }
    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }
    public function customerServices()
    {
        return $this->hasMany('App\Models\CustomerService');
    }
    public function customerTimelines()
    {
        return $this->hasMany('App\Models\CustomerTimeline');
    }
    public function notifyUsers()
    {
        return $this->hasMany('App\Models\NotifyUser');
    }
    public function notifyUserViews()
    {
        return $this->hasMany('App\Models\NotifyUserView');
    }
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
    public function roles()
    {
        return $this->hasMany('App\Models\Role');
    }
    public function roleUsers()
    {
        return $this->hasMany('App\Models\RoleUser');
    }
    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }
    public function sectors()
    {
        return $this->hasMany('App\Models\Sector');
    }
    public function teams()
    {
        return $this->hasMany('App\Models\Team');
    }
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
    public function websites()
    {
        return $this->hasMany('App\Models\Website');
    }
    public function websiteDatas()
    {
        return $this->hasMany('App\Models\WebsiteData');
    }

}
