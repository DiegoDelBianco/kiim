<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewBaseCustomer extends Model
{
    use HasFactory;
    
    protected $fillable = [
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
