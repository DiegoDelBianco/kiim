<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'picture',
        'title',
        'active',
        'address',
        'rent',
        'sale',
        'rooms',
        'suites',
        'bathrooms',
        'vehicle_space',
        'useful_area',
        'coverage',
        'availability',
        'property_entrance',
        'animals',
        'pool',
        'doorman',
        'property_relationship',
        'condo_value',
        'iptu',
        'sell_price',
        'rental_price',
        'status',
        'cep',
        'neighborhood',
        'uf',
        'city',
        'terms_accept',
        'detail',
        'done',
        'done_date',
        'tenancy_id',
        'description',
    ];

    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/

    /*belongsTo*/
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }
    
    /*hasMany*/
    public function websites()
    {
        return $this->hasMany('App\Models\Website');
    }
    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }

}
