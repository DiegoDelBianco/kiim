<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\RoleUser::factory()->create([
             'role_id' => '1',
             'user_id' => '1',
             'tenancy_id' => '1',
         ]);
    }
}
