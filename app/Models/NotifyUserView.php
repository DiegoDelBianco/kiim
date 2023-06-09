<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotifyUserView extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'notify_user_id',
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
