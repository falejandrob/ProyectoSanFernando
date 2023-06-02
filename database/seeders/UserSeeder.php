<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleGestor = Role::create(['name' => 'gestor']);
        $roleProfesor = Role::create(['name' => 'profesor']);

        User::create([
            'nombre' => "admin",
            'apellidos' => "admin",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'email' => "admin@admin.com",
            'remember_token' => Str::random(10),
        ])->assignRole($roleAdmin);
        User::create([
            'nombre' => "gestor",
            'apellidos' => "gestor",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'email' => "gestor@gestor.com",
            'remember_token' => Str::random(10),
        ])->assignRole($roleGestor);
        User::create([
            'nombre' => "profesor",
            'apellidos' => "profesor",
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
            'email' => "profesor@profesor.com",
            'remember_token' => Str::random(10),
        ])->assignRole($roleProfesor);
        /*User::create([
                'nombre' => "admin",
                'apellidos' => "null",
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'idRol' => 3,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'dni' => 'null',
                'curso' => 'null',
                'imagen' => 'null',
                'remember_token' => Str::random(10),
            ]
        )->assignRole($roleAdmin);*/
    }
}
