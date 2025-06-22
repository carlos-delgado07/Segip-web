<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios específicos
        $jose = User::factory()->create([
            'name' => 'Jose',
            'email' => 'josehco85@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $maria = User::factory()->create([
            'name' => 'Maria',
            'email' => 'maria@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $pedro = User::factory()->create([
            'name' => 'Pedro',
            'email' => 'pedro@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $luis = User::factory()->create([
            'name' => 'Luis',
            'email' => 'luis@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $ana = User::factory()->create([
            'name' => 'Ana',
            'email' => 'ana@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $carlos = User::factory()->create([
            'name' => 'Carlos',
            'email' => 'carlos@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        // Roles
        $role1 = Role::firstOrCreate(['name' => 'ADMINISTRADOR']);
        $role2 = Role::firstOrCreate(['name' => 'FUNCIONARIO']);
        $role3 = Role::firstOrCreate(['name' => 'USUARIO']);

        // Asignar roles a usuarios específicos
        $jose->assignRole($role1);
        $maria->assignRole($role2);
        $pedro->assignRole($role2);
        $luis->assignRole($role3);
        $ana->assignRole($role3);
        $carlos->assignRole($role2);

        // Crear 50 funcionarios
        User::factory()->count(50)->create([
            'password' => bcrypt('12345678')
        ])->each(function ($user) use ($role2) {
            $user->assignRole($role2);
        });

        // Crear 50 usuarios
        User::factory()->count(50)->create([
            'password' => bcrypt('12345678')
        ])->each(function ($user) use ($role3) {
            $user->assignRole($role3);
        });
    }
}
