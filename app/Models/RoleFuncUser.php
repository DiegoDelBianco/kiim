<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleFuncUser extends Model
{
    use HasFactory;

    // Crie regras aqui para serem usadas
    public $roles = [
        'user_update' => [
            'description' => 'Permite/Nega editar usuários nesta empresa',
            'name' => 'Editar usuários',
            'group_view' => 'Usuários'
        ],
        'user_create' => [
            'description' => 'Permite/Nega editar usuários nesta empresa',
            'name' => 'Editar usuários',
            'group_view' => 'Usuários'
        ],
    ];
}
