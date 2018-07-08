<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Permisologia\Role;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::dataForPaginate(['id', 'code', 'name', 'teacher_id'], function ($c) {
            $c->teacher_id = $c->teacher->fullName();
        });
        return $this->dataWithPagination($courses);
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
            'code' => 'required|max:15|min:2',
            'date_end_at' => 'required|date',
            'date_inscription_end_at' => 'required|date',
            'date_inscription_start_at' => 'required|date',
            'date_start_at' => 'required|date',
            'hour_end' => 'required|hour_corret',
            'hour_start' => 'required|hour_corret',
            'max_students' => 'required|numeric|max:100|min:1',
            'name' => 'required|string|max:50|min:5',
            'teacher_id' => 'required|numeric',
        ], [], [
            'code' => 'código',
            'date_end_at' => 'fecha final',
            'date_inscription_end_at' => 'fecha final',
            'date_inscription_start_at' => 'fecha inicial',
            'date_start_at' => 'fecha inicial',
            'hour_end' => 'hora final',
            'hour_start' => 'hora inicial',
            'max_students' => '',
            'name' => 'nombre',
            'teacher_id' => 'profesor',
        ]);
        $data['user_id'] = \Auth::user()->id;
        $data['slug'] = $data['name'] . ' - ' . \Carbon::now()->format('Y-m-d');
        $courses = Course::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::findOrFail($id);
        $course->teacher_ = $course->teacher->fullName() . ' - ' . $course->teacher->num_id;
        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'code' => 'required|max:15|min:2',
            'date_end_at' => 'required|date',
            'date_inscription_end_at' => 'required|date',
            'date_inscription_start_at' => 'required|date',
            'date_start_at' => 'required|date',
            'hour_end' => 'required|hour_corret',
            'hour_start' => 'required|hour_corret',
            'max_students' => 'required|numeric|max:100|min:1',
            'name' => 'required|string|max:50|min:5',
            'teacher_id' => 'required|numeric',
        ], [], [
            'code' => 'código',
            'date_end_at' => 'fecha final',
            'date_inscription_end_at' => 'fecha final',
            'date_inscription_start_at' => 'fecha inicial',
            'date_start_at' => 'fecha inicial',
            'hour_end' => 'hora final',
            'hour_start' => 'hora inicial',
            'max_students' => '',
            'name' => 'nombre',
            'teacher_id' => 'profesor',
        ]);
        Course::findOrFail($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id)->delete();
        return response()->json($course);
    }

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister($id)
    {
        $users = Role::findOrFail($id)
        ->users()
        ->orderBy('name', 'ASC')
        ->get(['id', 'name', 'last_name', 'num_id']);
        $users->each(function ($u) {
            $u->fullName = $u->fullName() . ' - ' . $u->num_id;
            unset($u->pivot);
        });
        return response()->json($users);
    }
}
