<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //user roles: 0 = admin, 1 = packaging, 2 = receiving, 3 = branch
        $users = [
                    ['name' => 'Dev Kim',
                        'email' => 'devkim@app.com',
                        'password' => bcrypt('DevKim@1'),
                        'role' => 0],
                    ['name' => 'Admin',
                        'email' => 'admin@optica.africa',
                        'password' => bcrypt('Admin@!!2023'),
                        'role' => 0],
                    ['name' => 'KE HQ Packaging',
                        'email' => 'packaging@optica.africa',
                        'password' => bcrypt('packaging@1'),
                        'role' => 1],
                    ['name' => 'KE HQ Receiving',
                        'email' => 'receiving@optica.africa',
                        'password' => bcrypt('receiving@1'),
                        'role' => 2],
                    ['name' => 'Optica House',
                        'email' => 'opticahouse@optica.africa',
                        'password' => bcrypt('opticahouse@1'),
                        'role' => 3],
                ];
        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}
