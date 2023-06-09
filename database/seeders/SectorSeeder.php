<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Sector::factory()->create([
             'name' => 'Adminitrativo',
             'description' => 'Setor de administrativo',
             'tenancy_id' => 1,
        ]);

        \App\Models\Sector::factory()->create([
             'name' => 'Vendas',
             'description' => 'Setor de vendas',
             'tenancy_id' => 1,
         ]);    

        \App\Models\Sector::factory()->create([
             'name' => 'Marketing',
             'description' => 'Setor de marketing',
             'tenancy_id' => 1,
        ]);
    }
}
