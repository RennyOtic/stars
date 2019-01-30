<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ { UserStoreRequest, UserUpdateRequest, ChangePasswordRequest };
use App\User;
use App\Models\ { Nationality, Course, HowFind, Company };
use App\Models\Permisologia\Role;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:user,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:user,show')->only(['show']);
        $this->middleware('can:user,destroy')->only(['destroy']);
    }

    /**
     * Muestra una lista de recursos en json o la vista.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::dataForPaginate(['name','id','last_name','email','num_id'], function ($u) {
            $rol = '';
            foreach ($u->roles as $r) {
                $rol .= '<span class="badge">' . $r->name . '</span>';
            }
            $u->rol = $rol;
            unset($u->roles);
            $u->fullName = $u->fullName();
        });
        return $this->dataWithPagination($users);
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        // $data['roles'] = $this->idsOfRol($data['roles']);
        $user = new User($data);
        $user->password = bcrypt($data['password']);
        $user->save();
        $user->roles()->attach($data['roles']);
        $user->assignPermissionsOneUser([$data['roles']]);

        if ($user->roles->first()->slug == 'profesor') {
            \Mail::to($user->correo)->send(new \App\Mail\WelcomeTeacher($user, $data['password']));
        }
        if ($user->roles->first()->slug == 'alumno') {
            \Mail::to($user->correo)->send(new \App\Mail\WelcomeStudent($user, $data['password']));
            $roles = Role::whereIn('id', [1,2,3])->get();
            $roles->each(function ($r) use ($user, $data) {
                $r->users->each(function ($u) use ($user, $data) {
                    \Mail::to($u->correo)->send(new \App\Mail\WelcomeStudent($user, $data['password']));
                });
            });
        }
    }

    /**
     * Mostrar el recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->fullName = $user->fullName();
        $user->roles;
        $howfind = HowFind::where('name', '=', $user->how_find)->first();
        if (!$howfind && !is_null($user->how_find)) {
            $user->how_find_other = $user->how_find;
            $user->how_find = 'Otro';
        }
        return response()->json($user);
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if($request->id == 1) return response(['errors' => 'Error al modificar usuario'], 422);

        $data = $request->validated();

        if( !empty($request->password) ){
            $data['password'] = bcrypt($this->validate($request, [
                'password' => 'string|min:6|confirmed'
            ])['password']);
        }

        $user = User::findOrFail($id)->fill($data);
        $user->update_pivot([$data['roles']], 'roles', 'role_id');
        $user->assignPermissionsOneUser([$data['roles']]);
        $user->save();
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id === 1) return response(['msg' => 'Error al modificar usuario'], 422);
        $user = User::findOrFail($id);
        $courses = Course::where('teacher_id', '=', $user->id)->get();
        $courses->each(function ($c) {
            $c->update(['teacher_id' => null]);
        });
        return response()->json($user->delete());
    }

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $roles = Role::where('id', '>=', \Auth::user()->roles->first()->id)->get(['name', 'id']);
        $nationalities = Nationality::get(['name', 'id']);
        $howfinds = HowFind::get(['name', 'id']);
        $companies = Company::get(['name', 'id', 'rut']);
        $companies->each(function ($c) {
            $c->text = $c->name . ' - ' . $c->rut;
            unset($c->pivot, $c->name, $c->rut);
        });
        $activities = [
            'Abogado',
            'Académico',
            'Administración Pública',
            'Administrador',
            'Administrador de empresas',
            'Administrativo',
            'Agrónomo',
            'Almacenero Almacenista',
            'Analista',
            'Anatomista',
            'Anestesiólogo Anestesista',
            'Antropólogo',
            'Archivero',
            'Arqueólogo',
            'Arquitecto',
            'Asesor',
            'Asistente',
            'Astrofísico',
            'Astrólogo',
            'Astrónomo',
            'Atleta',
            'Autor',
            'Auxiliar',
            'Avicultor',
            'Bacteriólogo',
            'Bibliógrafo',
            'Bibliotecario',
            'Biofísico',
            'Biógrafo',
            'Biólogo',
            'Bioquímico',
            'Botánico',
            'Buscando trabajo',
            'Cancerólogo',
            'Cardiólogo',
            'Cartógrafo',
            'Catedrático',
            'Cesante',
            'Cirujano',
            'Climatólogo',
            'Codirector',
            'Comunicador',
            'Audiovisual',
            'Contador',
            'Consejero',
            'Conserje',
            'Conservador',
            'Coordinador',
            'Cosmógrafo',
            'Cosmólogo',
            'Criminalista',
            'Cronólogo',
            'Decano',
            'Decorador',
            'Defensor',
            'Delegado',
            'Demógrafo',
            'Dentista',
            'Dermatólogo',
            'Dibujante',
            'Directivo',
            'Director',
            'Dirigente',
            'Doctor',
            'Documentalista',
            'Economista',
            'Educador',
            'Empresario',
            'Endocrinólogo',
            'Enfermero',
            'Enólogo',
            'Entomólogo',
            'Epidemiólogo',
            'Especialista',
            'Espeleólogo',
            'Estadista',
            'Estadístico',
            'Estudiante eduacación básica',
            'Estudiante educación media',
            'Estudiante Universitario',
            'Etnógrafo',
            'Etnólogo',
            'Examinador',
            'Facultativo',
            'Farmacéutico',
            'Farmacólogo',
            'Filólogo',
            'Filósofo',
            'Fiscal',
            'Físico',
            'Fisiólogo',
            'Fisioterapeuta',
            'Fonetista',
            'Fonólogo',
            'Forense',
            'Fotógrafo',
            'Funcionario',
            'Futbolista',
            'Genetista',
            'Geobotánica',
            'Geodesta',
            'Geofísico',
            'Geógrafo',
            'Geólogo',
            'Geómetra',
            'Geoquímica',
            'Gerente de area',
            'Gerente general',
            'Geriatra',
            'Gerontólogo',
            'Gestor',
            'Graduado social',
            'Grafólogo',
            'Gramático',
            'Hematólogo',
            'Hepatólogo',
            'Hidrogeólogo',
            'Hidrógrafo',
            'Historiador',
            'Homeópata',
            'Informático',
            'Ingeniero Civil',
            'Ingeniero comercial',
            'Ingeniero en Construcción',
            'Ingeniero en minas',
            'Ingeniero Industrial',
            'Ingeniero informático',
            'Ingeniero Mecánico',
            'Ingeniero Químico',
            'Ingeniero técnico',
            'Inmunólogo',
            'Inspector',
            'Interino',
            'Interventor',
            'Investigador',
            'Jardinero',
            'Jefe',
            'Juez',
            'Lingüista',
            'Maestro',
            'Matemático',
            'Matrón',
            'Medico',
            'Meteorólogo',
            'Microbiológico',
            'Militar',
            'Monitor',
            'Musicólogo',
            'Naturópata',
            'Nefrólogo',
            'Neuroanatomista',
            'Neurobiólogo',
            'Neurocirujano',
            'Neuroembriólogo',
            'Neurofisiólogo',
            'Neurólogo',
            'Oceanógrafo',
            'Oculista',
            'Odontólogo',
            'Oficial',
            'Oficinista',
            'Oftalmólogo',
            'Oncólogo',
            'Óptico',
            'Optometrista',
            'Orientador',
            'Ornitólogo',
            'Ortopédico',
            'Ortopedista',
            'Osteólogo',
            'Osteópata',
            'Otorrinolaringólogo',
            'Paleontólogo',
            'Pedagogo',
            'Pediatra',
            'Pedicuro',
            'Peluquero',
            'Periodista',
            'Perito',
            'Piscicultor',
            'Podólogo',
            'Policía',
            'Presidente',
            'Proctólogo',
            'Profesor de colegio',
            'Profesor de inglés',
            'Profesor Universitario',
            'Programador',
            'Psicoanalista',
            'Psicofísico',
            'Psicólogo',
            'Psicopedagogo',
            'Psicoterapeuta',
            'Psiquiatra',
            'Publicista',
            'Publicitario',
            'Químico',
            'Químico Farmaceutico',
            'Quiropráctico',
            'Radiólogo',
            'Radiotécnico',
            'Rector',
            'Secretario',
            'Sexólogo',
            'Sismólogo',
            'Sociólogo',
            'Subdelegado',
            'Subdirector',
            'Subsecretario',
            'Técnico',
            'Técnico Agente o Visitador Médico',
            'Técnico en Administración de Empresas',
            'Técnico en Administración de Redes y Soporte',
            'Técnico en Administración Financiera y Finanzas',
            'Técnico en Análisis de Sistemas',
            'Técnico en Comercio Exterior',
            'Técnico en Contabilidad General',
            'Técnico en Contabilidad Tributaria',
            'Técnico en Dibujo Técnico e Industrial',
            'Técnico en Electricidad y Electricidad Industrial',
            'Técnico en Electrónica y Electrónica Industrial',
            'Técnico en Instrumentación, Automatización y Control Industrial',
            'Técnico en Logística',
            'Técnico en Mantenimiento Industrial',
            'Técnico en Mecánica Automotriz',
            'Técnico en Mecánica Industrial',
            'Técnico en Prevención de Riesgos',
            'Técnico en Química (Análisis e Industrial)',
            'Técnico en Telecomunicaciones',
            'Técnico en Topografía',
            'Telefonista',
            'Teólogo',
            'Terapeuta',
            'Toxicólogo',
            'Traductor',
            'Traumatólogo',
            'Tutor',
            'Urólogo',
            'Veterinario',
            'Vicedecano',
            'Vicedirector',
            'Vicegerente',
            'Vicepresidente',
            'Vicerrector',
            'Vicesecretario',
            'Virólogo',
            'Viticultor',
            'Vulcanólogo',
            'Zoólogo',
            'Otro',
        ];
        return response()->json(compact('roles', 'nationalities', 'howfinds', 'companies', 'activities'));
    }

}
