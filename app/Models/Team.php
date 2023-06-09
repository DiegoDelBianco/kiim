<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name',
        'picture',
        'tenancy_id',
    ];

    // Retonar quantos clientes estão na fila da equipe aguardando para serem atendidos
    public function customers_queue_count(){
        return Customer::where([['team_id', '=', $this->team_id], ['user_id', "=", NULL]])->count();
    }

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
    public function notifyUsers()
    {
        return $this->hasMany('App\Models\NotifyUser');
    }
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
