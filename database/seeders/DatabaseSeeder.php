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

        $peserta1 = User::create([
            'code' => uniqid(),
            'username' => '21050400014',
            'password' => '123',
            'email' => 'new@unimma.ac.id',
            'email_verified_at' => now()
        ]);

        DataDiri::create([
            'user_id' => $peserta1->id,
            'name' => 'Afnan Ahsana Syadida',
            'gender' => 'Laki-laki',
            'address' => 'Borobudur, Kec. Borobudur, Kab. Magelang',
            'phone_number' => '0812313131231231',
            'birth_date' => '2003-02-07',
            'birth_place' => 'Magelang',
            'profile_picture' => null,
        ]);

        $admin1 = User::create([
            'code' => uniqid(),
            'username' => '21050400013',
            'password' => '123',
            'email' => 'new2@unimma.ac.id',
            'email_verified_at' => now()
        ]);

        DataDiri::create([
            'user_id' => $admin1->id,
            'name' => 'Bachtiar Fawwaz',
            'gender' => 'Laki-laki',
            'address' => 'Borobudur, Kec. Borobudur, Kab. Magelang',
            'phone_number' => '0812313131231231',
            'birth_date' => '2003-06-07',
            'birth_place' => 'Magelang',
            'profile_picture' => null,
        ]);

        $instruktur1 = User::create([
            'code' => uniqid(),
            'username' => '21050400012',
            'password' => '123',
            'email' => 'new3@unimma.ac.id',
            'email_verified_at' => now()
        ]);

        DataDiri::create([
            'user_id' => $instruktur1->id,
            'name' => 'Ulil Albab',
            'gender' => 'Laki-laki',
            'address' => 'Kec.Muntilan , Kab. Magelang',
            'phone_number' => '0812313131231231',
            'birth_date' => '2000-06-07',
            'birth_place' => 'Magelang',
            'profile_picture' => null,
        ]);

        $roleDewa = Role::create(['name' => 'SuperAdmin']);
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleInstruktur = Role::create(['name' => 'Instruktur']);
        $rolePeserta = Role::create(['name' => 'Peserta']);

        $dewa1->assignRole($roleDewa);
        $dewa2->assignRole($roleDewa);
        $peserta1->assignRole($rolePeserta);
        $admin1->assignRole($roleAdmin);
        $instruktur1->assignRole($roleInstruktur);
    }
}
