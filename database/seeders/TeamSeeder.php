<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Team::factory()->create([
             'name' => 'Stark',
             'tenancy_id' => 1,
        ]);  

        \App\Models\Team::factory()->create([
             'name' => 'Lannister',
             'tenancy_id' => 1,
        ]); 

        \App\Models\Team::factory()->create([
             'name' => 'Targaryen',
             'tenancy_id' => 1,
        ]);  
    }
}
