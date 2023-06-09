<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotifyUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'text',
        'style',
        'shoot',
        'team_id',
        'user_id',
        'tenancy_id',
    ];

    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/

    /*belongsTo*/
    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }
    
    /*hasMany*/
}
