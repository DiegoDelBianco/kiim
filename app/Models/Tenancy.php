<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

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

    public static function newTenancyWithUser($business_name, $name, $email, $password)
    {

        $tenancy = Tenancy::create([
            'name' => $business_name,
        ]);

        // create roles
        /*$role_master = Role::create([
            'name' => 'Master',
            'description' => 'Administrador',
            'tenancy_id' => $tenancy->id,
        ]);
        $role_gerente = Role::create([
            'name' => 'Gerente',
            'description' => 'Gerente de Equipe',
            'tenancy_id' => $tenancy->id,
        ]);
        $role_basico = Role::create([
            'name' => 'Básico',
            'description' => 'Acesso básico para atendimento',
            'tenancy_id' => $tenancy->id,
        ]);*/

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'tenancy_id' => $tenancy->id,
        ]);

        $tenancy->user_id = $user->id;
        $tenancy->save();

        // assign roles to user
        RoleUser::create([
            'user_id' => $user->id,
            'name' => 'admin',
            'tenancy_id' => $tenancy->id,
        ]);


        event(new Registered($user));

        return $user;
    }

    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/
    public function sysProducts()
    {
        return $this->belongsToMany('App\Models\SysProduct', 'sys_product_tenancies');
    }
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'role_user');
        // return $this->hasMany('App\Models\User');
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
    public function websites()
    {
        return $this->hasMany('App\Models\Website');
    }
    public function websiteDatas()
    {
        return $this->hasMany('App\Models\WebsiteData');
    }

}
