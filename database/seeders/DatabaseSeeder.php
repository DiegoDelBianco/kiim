<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TenancySeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(SectorSeeder::class);
        
        \App\Models\User::factory(3)->create();

        $this->call(RoleUserSeeder::class);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
