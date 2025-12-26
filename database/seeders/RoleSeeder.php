<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => 'super_admin',
            'description' => 'Super administrador con acceso total',
        ]);

        Role::create([
            'name' => 'admin',
            'description' => 'Administrador de equipos y proyectos',
        ]);

        Role::create([
            'name' => 'user',
            'description' => 'Usuario normal',
        ]);
    }
}
