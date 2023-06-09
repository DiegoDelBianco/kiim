<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name',
        'description',
        'module',
        'action',
        'nivel',
        'tenancy_id',
    ];

    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/
    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    /*belongsTo*/
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }
    
    /*hasMany*/

}
