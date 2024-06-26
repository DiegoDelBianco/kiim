<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Tenancy::factory()->create([
             'subdomain' => 'empresateste',
             'name' => 'Empresa Teste',
         ]);
    }
}
