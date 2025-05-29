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
            //Acceso a Mantenedores
            'Acceso al Mantenedor de Alumnos',
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
            'Acceso al Mantenedor de Administradores',
            'Acceso al Mantenedor de Roles',
            'Acceso al Mantenedor de Equipos',
            'Acceso al Mantenedor de Torneos',
            'Acceso al Mantenedor de Rutinas',
            'Acceso al Mantenedor de Talleres',
            'Acceso al Mantenedor de Ejercicios',
            'Acceso al Mantenedor de Carreras',

            //Acceso a funcionalidades de gestión
            'Acceso a Gestión de QR',
            'Acceso a Gestión de Asistencia Talleres',

            //Accesos a Salas Abiertas
            'Acceso a Salas Abiertas',

            //Acceso al Mantenedor de Usuarios
            'Ver Usuarios',
            'Crear Usuarios',
            'Editar Usuarios',
            'Eliminar Usuarios',

            //Acceso a las noticias
            'Crear Noticias',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $director = Role::create(['name' => 'Director']);
        $docente = Role::create(['name' => 'Docente']);
        $coordinador = Role::create(['name' => 'Coordinador']);
        $visor_qr = Role::create(['name' => 'Visor QR']);

        // Asignar todos los permisos al Super Admin
        $permissions_ver_sala = 'Acceso a Salas Abiertas';
        $permissions_super_admin = Permission::where('name', '!=', $permissions_ver_sala)->get();

        $superAdmin->givePermissionTo($permissions_super_admin);

        // Asignar permisos específicos al Director
        $director->givePermissionTo([
            'Acceso al Mantenedor de Alumnos',
            'Acceso al Mantenedor de Deportes',
            'Acceso al Mantenedor de Máquinas',
            'Acceso al Mantenedor de Marcas',
            'Acceso al Mantenedor de Sucursales',
            'Acceso al Mantenedor de Espacios',
            'Acceso al Mantenedor de Salas',
            'Acceso al Mantenedor de Tipos de Espacios',
            'Acceso al Mantenedor de Tipos de Sanción',
            'Acceso a Gestión de QR',
            'Acceso al Mantenedor de Equipos',
            'Acceso al Mantenedor de Torneos',
            'Acceso al Mantenedor de Talleres',
            //Acceso al Mantenedor de Usuarios
            'Ver Usuarios',
            'Crear Usuarios',
            'Editar Usuarios',
            'Eliminar Usuarios',
            'Crear Noticias',
        ]);

        // Asignar permisos específicos al Docente
        $docente->givePermissionTo([
            'Acceso al Mantenedor de Alumnos',
            'Acceso a Gestión de QR',
            'Acceso al Mantenedor de Talleres',
            'Acceso a Gestión de Asistencia Talleres',
            'Acceso al Mantenedor de Rutinas',
            'Acceso al Mantenedor de Equipos',
            'Acceso al Mantenedor de Torneos',
            'Acceso al Mantenedor de Deportes',
            'Ver Usuarios',
            'Crear Noticias',
        ]);

        // Asignar permisos específicos al Coordinador
        $coordinador->givePermissionTo([
            'Acceso al Mantenedor de Alumnos',
            'Acceso al Mantenedor de Deportes',
            'Acceso al Mantenedor de Máquinas',
            'Acceso al Mantenedor de Espacios',
            'Acceso al Mantenedor de Salas',
            'Acceso al Mantenedor de Tipos de Espacios',
            'Acceso al Mantenedor de Tipos de Sanción',
            'Acceso a Gestión de QR',
            'Acceso a Salas Abiertas',
            'Acceso al Mantenedor de Equipos',
            'Acceso al Mantenedor de Torneos',
            'Ver Usuarios',
            'Editar Usuarios',
            'Crear Noticias',
        ]);
        // Asignar permisos específicos al Visor QR
        $visor_qr->givePermissionTo([
            'Acceso a Gestión de QR',
            'Acceso a Salas Abiertas',
        ]);
    }
}