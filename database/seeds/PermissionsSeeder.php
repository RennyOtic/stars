<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Permisos de usuarios
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Usuarios',
            'module' => 'user',
            'action' => 'index',
            'description' => 'Permiso para Ver usuarios'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Usuarios',
            'module' => 'user',
            'action' => 'store',
            'description' => 'Permiso para registrar usuarios'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Usuario',
            'module' => 'user',
            'action' => 'show',
            'description' => 'Permiso para Ver usuario'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Editar Usuarios',
            'module' => 'user',
            'action' => 'update',
            'description' => 'Permiso para editar usuarios'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Borrar Usuarios',
        	'module' => 'user',
        	'action' => 'destroy',
        	'description' => 'Permiso para borrar usuarios'
        ]);

        /**
         * Permisos de Roles
         */
        App\Models\Permisologia\Permission::create([
        	'name' => 'Ver Roles',
        	'module' => 'rol',
        	'action' => 'index',
        	'description' => 'Permiso para ver roles'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Roles',
            'module' => 'rol',
            'action' => 'store',
            'description' => 'Permiso para registrar roles'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Rol',
            'module' => 'rol',
            'action' => 'show',
            'description' => 'Permiso para ver un rol'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Actualizar Roles',
        	'module' => 'rol',
        	'action' => 'update',
        	'description' => 'Permiso para actualizar roles'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Eliminar Roles',
        	'module' => 'rol',
        	'action' => 'destroy',
        	'description' => 'Permiso para Eliminar roles'
        ]);

        /**
         * Permisos de Permisos
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Permisos',
            'module' => 'permission',
            'action' => 'index',
            'description' => 'Permiso para Ver Permisos'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Ver Permiso',
        	'module' => 'permission',
        	'action' => 'show',
        	'description' => 'Permiso para Ver un Permiso'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Modificar Permisos',
        	'module' => 'permission',
        	'action' => 'update',
        	'description' => 'Permiso para Eliminar Permisos'
        ]);

        /**
         * Permisos de Cursos
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Cursos',
            'module' => 'courseManagement',
            'action' => 'index',
            'description' => 'Permiso para ver Cursos'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Cursos',
            'module' => 'courseManagement',
            'action' => 'store',
            'description' => 'Permiso para registrar Cursos'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Curso',
            'module' => 'courseManagement',
            'action' => 'show',
            'description' => 'Permiso para ver un Curso'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Cursos',
            'module' => 'courseManagement',
            'action' => 'update',
            'description' => 'Permiso para actualizar Cursos'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Eliminar Cursos',
            'module' => 'courseManagement',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Cursos'
        ]);

        /**
         * Permisos de Inscripciones
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Inscripciones',
            'module' => 'inscription',
            'action' => 'index',
            'description' => 'Permiso para ver los alumnos inscritos'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Inscribir alumno',
            'module' => 'inscription',
            'action' => 'store',
            'description' => 'Permiso para registrar alumnos al curso'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Quitar alumno',
            'module' => 'inscription',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Alumno del curso'
        ]);

        /**
         * Permisos de Control de Asistencias
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Control de Asistencia',
            'module' => 'assistanceControl',
            'action' => 'index',
            'description' => 'Permiso para ver Cursos'
        ]);

        // App\Models\Permisologia\Permission::create([
        //     'name' => 'Crear Cursos',
        //     'module' => 'assistanceControl',
        //     'action' => 'store',
        //     'description' => 'Permiso para registrar Cursos'
        // ]);

        // App\Models\Permisologia\Permission::create([
        //     'name' => 'Ver Curso',
        //     'module' => 'assistanceControl',
        //     'action' => 'show',
        //     'description' => 'Permiso para ver un Curso'
        // ]);

        // App\Models\Permisologia\Permission::create([
        //     'name' => 'Actualizar Cursos',
        //     'module' => 'assistanceControl',
        //     'action' => 'update',
        //     'description' => 'Permiso para actualizar Cursos'
        // ]);

        // App\Models\Permisologia\Permission::create([
        //     'name' => 'Eliminar Cursos',
        //     'module' => 'assistanceControl',
        //     'action' => 'destroy',
        //     'description' => 'Permiso para Eliminar Cursos'
        // ]);

    }
}
