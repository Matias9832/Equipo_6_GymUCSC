<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos
        $permissions = [
            'Acceso al Mantenedor de Alumnos',
            'Acceso al Mantenedor de Usuarios',
            'Acceso al Mantenedor de Deportes',
            'Acceso al Mantenedor de Máquinas',
            'Acceso al Mantenedor de Marcas',
            'Acceso al Mantenedor de Países',
            'Acceso al Mantenedor de Regiones',
            'Acceso al Mantenedor de Ciudades',
            'Acceso al Mantenedor de Sucursales',
            'Acceso al Mantenedor de Espacios',
            'Acceso al Mantenedor de Salas',
            'Acceso al Mantenedor de Tipos de Espacios',
            'Acceso al Mantenedor de Tipos de Sanción',
            'Acceso al Mantenedor de Gestión de QR',
            'Acceso al Mantenedor de Administradores',
            'Acceso al Mantenedor de Roles',
            'Acceso al Mantenedor de Equipos',
            'Acceso al Mantenedor de Torneos',
            
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $director = Role::create(['name' => 'Director']);
        $docente = Role::create(['name' => 'Docente']);

        // Asignar todos los permisos al Super Admin
        $superAdmin->givePermissionTo(Permission::all());

        // Asignar permisos específicos al Director
        $director->givePermissionTo([
            'Acceso al Mantenedor de Alumnos',
            'Acceso al Mantenedor de Usuarios',
            'Acceso al Mantenedor de Deportes',
            'Acceso al Mantenedor de Máquinas',
            'Acceso al Mantenedor de Marcas',
            'Acceso al Mantenedor de Países',
            'Acceso al Mantenedor de Regiones',
            'Acceso al Mantenedor de Ciudades',
            'Acceso al Mantenedor de Sucursales',
            'Acceso al Mantenedor de Espacios',
            'Acceso al Mantenedor de Salas',
            'Acceso al Mantenedor de Tipos de Espacios',
            'Acceso al Mantenedor de Tipos de Sanción',
            'Acceso al Mantenedor de Gestión de QR',
            'Acceso al Mantenedor de Equipos',
            'Acceso al Mantenedor de Torneos',
        ]);

        // Asignar permisos específicos al Docente
        $docente->givePermissionTo([
            'Acceso al Mantenedor de Alumnos',
            'Acceso al Mantenedor de Usuarios',
            'Acceso al Mantenedor de Gestión de QR',
        ]);
    }
}