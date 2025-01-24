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

        $dewa1 = User::create([
            'code' => uniqid(),
            'username' => 'dewamatahari',
            'password' => '123',
            'email' => 'naufalaf86@gmail.com',
            'email_verified_at' => now()
        ]);

        $dewa2 = User::create([
            'code' => uniqid(),
            'username' => 'dewabulan',
            'password' => '123',
            'email' => 'ayip@unimma.ac.id',
            'email_verified_at' => now()
        ]);


        $roleDewa = Role::create(['name' => 'SuperAdmin']);
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleInstruktur = Role::create(['name' => 'Instruktur']);
        $rolePeserta = Role::create(['name' => 'Peserta']);

        $dewa1->assignRole($roleDewa);
        $dewa2->assignRole($roleDewa);
    }
}
