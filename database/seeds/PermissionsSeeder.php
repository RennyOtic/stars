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

        App\Models\Permisologia\Permission::create([
        	'name' => 'Restaurar Usuarios',
        	'module' => 'user',
        	'action' => 'restore',
        	'description' => 'Permiso para Restaurar usuarios'
        ]);

        /**
         * Permisos de Perfiles
         */
        App\Models\Permisologia\Permission::create([
        	'name' => 'Ver Perfiles',
        	'module' => 'rol',
        	'action' => 'index',
        	'description' => 'Permiso para ver Perfiles'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Perfil',
            'module' => 'rol',
            'action' => 'store',
            'description' => 'Permiso para registrar Perfil'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Perfil',
            'module' => 'rol',
            'action' => 'show',
            'description' => 'Permiso para ver un Perfil'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Actualizar Perfil',
        	'module' => 'rol',
        	'action' => 'update',
        	'description' => 'Permiso para actualizar Perfil'
        ]);

        App\Models\Permisologia\Permission::create([
        	'name' => 'Eliminar Perfil',
        	'module' => 'rol',
        	'action' => 'destroy',
        	'description' => 'Permiso para Eliminar Perfil'
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

        App\Models\Permisologia\Permission::create([
            'name' => 'Registrar Asistencia',
            'module' => 'assistanceControl',
            'action' => 'store',
            'description' => 'Permiso para registrar Asistencia'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Asistencia',
            'module' => 'assistanceControl',
            'action' => 'update',
            'description' => 'Permiso para actualizar Asistencia'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Motivos del profesor',
            'module' => 'assistanceControl',
            'action' => 'showTeacher',
            'description' => 'Permiso Ver los motivos de cancelación del profesor'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Motivos del estudiante',
            'module' => 'assistanceControl',
            'action' => 'showStudent',
            'description' => 'Permiso Ver los motivos de cancelación del Estudiante'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Mostrar cursos Inscritos',
            'module' => 'assistanceControl',
            'action' => 'showDataInscription',
            'description' => 'Permiso Ver La tabla de Asistencia llena con los cursos inscritos del estudiante'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Mostrar cursos que Enseña',
            'module' => 'assistanceControl',
            'action' => 'showDataTeacher',
            'description' => 'Permiso Ver La tabla de Asistencia llena con los cursos en el que el profesor enseña'
        ]);

        /**
         * Permisos de Empresas
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Empresas',
            'module' => 'company',
            'action' => 'index',
            'description' => 'Permiso para ver Empresas'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Empresas',
            'module' => 'company',
            'action' => 'store',
            'description' => 'Permiso para registrar Empresas'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Empresa',
            'module' => 'company',
            'action' => 'show',
            'description' => 'Permiso para ver un Empresa'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Empresas',
            'module' => 'company',
            'action' => 'update',
            'description' => 'Permiso para actualizar Empresas'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Eliminar Empresas',
            'module' => 'company',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Empresas'
        ]);

        /**
         * Permisos de Notificaciones de suspención
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Notificaciones de Suspenciones',
            'module' => 'notify_s',
            'action' => 'index',
            'description' => 'Permiso para ver Notificaciones de Suspenciones'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Crear Notificación de Suspención',
            'module' => 'notify_s',
            'action' => 'store',
            'description' => 'Permiso para registrar Notificación de Suspención'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Notificación de Suspención',
            'module' => 'notify_s',
            'action' => 'show',
            'description' => 'Permiso para ver una Notificación de Suspención'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Actualizar Notificación de Suspención',
            'module' => 'notify_s',
            'action' => 'update',
            'description' => 'Permiso para actualizar Notificación de Suspención'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Eliminar Notificación de Suspención',
            'module' => 'notify_s',
            'action' => 'destroy',
            'description' => 'Permiso para Eliminar Notificación de Suspención'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Ver Todas las Notificaciones',
            'module' => 'notify_s',
            'action' => 'all',
            'description' => 'Permiso para Ver Todoes los registros de Notificación de Suspención'
        ]);

        /**
         * Permisos de Reports
         */
        App\Models\Permisologia\Permission::create([
            'name' => 'Reporte de inscripción',
            'module' => 'report',
            'action' => 'inscription',
            'description' => 'Permiso para Generar Reportes de inscripción a un Curso'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Reporte de Cursos Inscritos',
            'module' => 'report',
            'action' => 'course_inscription',
            'description' => 'Permiso para Generar Reportes de Cursos Inscritos de un alumno'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Reporte de Asistencias',
            'module' => 'report',
            'action' => 'assistance',
            'description' => 'Permiso para Generar Reportes de Asistencias de un alumno'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Reporte de Cursos por Profesor',
            'module' => 'report',
            'action' => 'course_teacher',
            'description' => 'Permiso para Generar Reportes de Cursos por Profesor'
        ]);

        App\Models\Permisologia\Permission::create([
            'name' => 'Reporte de Pago de Profesor',
            'module' => 'report',
            'action' => 'pay_teacher',
            'description' => 'Permiso para Generar Reportes de Pago de Profesor'
        ]);

    }
}