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

        $data2 = $this->validate($request, [
            'student_id' => 'required|numeric|is_student',
            'email'     => 'required|email|min:8|max:35|unique1:users',
            'last_name' => 'required|alpha_space|min:3|max:15',
            'name'      => 'required|alpha_space|min:3|max:15',
            'num_id'    => 'required|numeric|digits_between:6,8|exr_ced|unique1:users',
            'birthday_date' => 'required|date',
            'nationality_id' => 'required|numeric',
            'occupation' => 'required|string|max:25|min:3',
            'phone_home' => 'required|numeric|digits:10',
            'phone_movil' => 'required|numeric|digits:10',
            'how_find' => 'required|alpha_space',
            'how_find_other' => 'required_if:how_finds_id,1|string|max:30|min:3',
            'company_id' => 'required|numeric'
        ], [], [
            'company_id'     => 'empresa',
            'email'     => 'correo',
            'last_name' => 'apellido',
            'name'      => 'nombre',
            'num_id'    => 'cédula',
            'password'  => 'contraseña',
            'roles'     => 'roles',
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
        if ($is_in_course)
            return response()->json(['message' => 'El alumno ya se encuentra inscrito.'], 401);

        $now = \Carbon::now();
        User::findOrFail($data['student_id'])->update($data2);
        $course->users()->attach($data['student_id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $this->validate($request, [
            'id' => 'required|numeric|is_student'
        ], [], [
            'id' => 'estudiante'
        ]);
        $alumn = Course::findOrFail($id)->users()->where('user_id', '=', $data['id'])->count();
        if ($alumn) {
            return Course::findOrFail($id)->users()->detach($data['id']);
        }
    }

    /**
     * Retorna los alumnos para anexarlo a un curso.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $students = \App\Models\Permisologia\Role::where('slug', '=', 'Alumno')
        ->findOrFail(3)->users()->orderBy('name', 'ASC')
        ->get(['id', 'name', 'last_name', 'num_id']);

        $students->each(function ($u) {
            $u->text = $u->fullName() . ' - ' . $u->num_id;
            unset($u->pivot);
        });

        return response()->json(compact('students'));
    }
}
