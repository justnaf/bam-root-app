<?php

namespace Database\Seeders;

use App\Models\DataDiri;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        $roleDewa = Role::create(['name' => 'SuperAdmin']);
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleInstruktur = Role::create(['name' => 'Instruktur']);
        $rolePeserta = Role::create(['name' => 'Peserta']);
    }
}
