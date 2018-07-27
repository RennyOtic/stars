<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;

class InscriptionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('onlyAjax');
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
        ->Where('name', 'LIKE', "%{$request->search}%")
        ->orWhere('num_id', 'LIKE', "%{$request->search}%")
        ->orWhere('last_name', 'LIKE', "%{$request->search}%")
        ->orderBy($request->order?:'id', $request->dir?:'ASC')
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

        $is_in_course = Course::findOrFail($data['id'])->users()->where('user_id', '=', $data['student_id'])->count();
        if ($is_in_course) {
            return response()->json(['message' => 'El alumno ya se encuentra inscrito.'], 401);
        }

        Course::findOrFail($data['id'])->users()->attach($data['student_id']);
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
