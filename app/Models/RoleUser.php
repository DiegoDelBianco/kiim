<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Model
{
    use HasFactory;//, SoftDeletes;

    protected $table = 'role_user';

    protected $fillable = [
        'user_id',
        //'role_id',        // Descontinuado
        'name',
        'allow',
        'tenancy_id',
    ];

    public static $roles = [
        'admin' => [
            'description' => 'Administrador do sistema',
            'name' => 'Admin'
        ],
        'manager' => [
            'description' => 'Gerencia todas as equipes',
            'name' => 'Gerente Geral'
        ],
        'team_manager' => [
            'description' => 'Gerencia apenas a sua equipe',
            'name' => 'Gerente'
        ],
        'basic' => [
            'description' => 'Corretor',
            'name' => 'Corretor'
        ],
    ];


    public static function get_roles_list()
    {
        return RoleUser::$roles;
    }

    public static function roleIsset($role)
    {
        $roles = RoleUser::$roles;
        return isset($roles[$role]);
    }

    public function showName()
    {
        if(!isset(RoleUser::$roles[$this->name]))
            return 'Não definido';

        return RoleUser::$roles[$this->name]['name'];
    }

    public function showDescription()
    {
        if(!isset(RoleUser::$roles[$this->name]))
            return 'Não definido';
        return RoleUser::$roles[$this->name]['description'];
    }

    public static function getRoleShowName($role)
    {
        if(!isset(RoleUser::$roles[$role]))
            return 'Não definido';

        return RoleUser::$roles[$role]['name'];
    }

    public static function getRoleShowDescription($role)
    {
        if(!isset(RoleUser::$roles[$role]))
            return 'Não definido';

        return RoleUser::$roles[$role]['description'];
    }

    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/

    /*belongsTo*/
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }
    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }

    /*hasMany*/

}
