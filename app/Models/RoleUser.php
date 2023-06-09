<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'role_user';
    
    protected $fillable = [
        'user_id',
        'role_id',
        'allow',
        'tenancy_id',
    ];

    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/

    /*belongsTo*/
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }
    
    /*hasMany*/

}
