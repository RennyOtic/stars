<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ { Course, HowFind };
use App\User;

class InscriptionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:inscription,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:inscription,store')->only(['store']);
        $this->middleware('can:inscription,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $course = Course::findOrFail($request->data)
        ->users()
        ->Where('num_id', 'LIKE', "%{$request->search}%")
        ->orderBy($request->order?:'id', $request->dir?:'DESC')
        ->select(['email', 'id', 'last_name', 'name', 'num_id'])
        ->paginate($request->num?:10);

        $course->each(function ($c) {
            $c->fullName = $c->fullName();
            unset($c->pivot);
        });

        return $this->dataWithPagination($course);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'id' => 'required|numeric',
            'student_id' => 'required|numeric|is_student',
        ], [], ['student_id' => 'Alumno']);

        $user = User::findOrFail($data['student_id']);

        $num_id = '';
        if ($user->type == 1) {
            $num_id = 'id';
            $num_t = 'RUT';
        } elseif ($user->type == 2) {
            $num_id = 'string|min:5|max:20'; /*pass*/
            $num_t = 'pasaporte';
        }

        $data2 = $this->validate($request, [
            'student_id' => 'required|numeric|is_student',
            'email'     => 'required|email|min:8|max:35|unique1:users',
            'last_name' => 'required|alpha_space|min:3|max:15',
            'name'      => 'required|alpha_space|min:3|max:15',
            'num_id'    => 'required|' . $num_id . '|unique1:users',
            'birthday_date' => 'required|date',
            'nationality_id' => 'required|numeric',
            'occupation' => 'required|string|max:25|min:3',
            'phone_home' => 'nullable|phone',
            'phone_movil' => 'required|phone',
            'how_find' => 'required|alpha_space',
            'how_find_other' => 'required_if:how_finds_id,1|string|max:30|min:3',
            'company_id' => 'nullable|numeric'
        ], [], [
            'company_id'     => 'empresa',
            'email'     => 'correo',
            'last_name' => 'apellido',
            'name'      => 'nombre',
            'num_id'    => $num_t,
            'password'  => 'contraseña',
            'roles'     => 'perfiles',
            'birthday_date' => 'fecha de cumpleaños',
            'nationality_id' => 'nacionalidad',
            'occupation' => 'ocupación',
            'phone_home' => 'telefono de contacto',
            'phone_movil' => 'telefono movil',
            'how_find' => 'medio',
            'how_find_other' => 'medio'
        ]);

        if ($data2['how_find'] == 'Otro') $data2['how_find'] = $data2['how_find_other'];

        $course = Course::findOrFail($data['id']);
        $is_in_course = $course->users()->where('user_id', '=', $data['student_id'])->count();
        if ($is_in_course) return response()->json(['message' => 'El alumno ya se encuentra inscrito.'], 401);

        $now = \Carbon::now();
        $user->update($data2);
        $course->users()->attach($data['student_id']);
        $course->updateAlumns();
        \Mail::to($course->teacher->email)
        ->send(new \App\Mail\InscriptionToTeacher($course));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $this->validate($request, ['id' => 'required|numeric|is_student'],[],['id' => 'estudiante']);
        $course = Course::findOrFail($id);
        $alumn = $course->users()->where('user_id', '=', $data['id'])->count();
        if ($alumn) return Course::findOrFail($id)->users()->detach($data['id']);
        $course->updateAlumns();
    }

    /**
     * Retorna los alumnos para anexarlo a un curso.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $students = \App\Models\Permisologia\Role::where('slug', '=', 'Alumno')
        ->first()->users()->orderBy('name', 'ASC')
        ->get(['id', 'name', 'last_name', 'num_id']);

        $students->each(function ($u) {
            $u->text = $u->fullName() . ' - ' . $u->num_id;
            unset($u->pivot);
        });

        return response()->json(compact('students'));
    }
}
