<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::factory()->create([
             'name' => 'Master',
             'description' => 'Administrador',
             'tenancy_id' => 1,
         ]);
        \App\Models\Role::factory()->create([
             'name' => 'Gerente',
             'description' => 'Gerente de Equipe',
             'tenancy_id' => 1,
         ]);
        \App\Models\Role::factory()->create([
             'name' => 'Básico',
             'description' => 'Gerente de Equipe',
             'tenancy_id' => 1,
         ]);
    }
}
