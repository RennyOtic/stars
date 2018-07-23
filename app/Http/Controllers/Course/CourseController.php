<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Permisologia\Role;
use App\Http\Requests\ { CourseStoreRequest, CourseUpdateRequest };

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('onlyAjax');
        $this->middleware('can:courseManagement,index')->only(['index']);
        $this->middleware('can:courseManagement,show')->only(['show']);
        $this->middleware('can:courseManagement,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::dataForPaginate(['id', 'code', 'name', 'teacher_id', 'idioma_id', 'level_id'], function ($c) {
            $c->teacher_id = $c->teacher->fullName();
            $c->idioma_id = $c->idioma->name;
            $c->level_id = $c->level->name;
            unset($c->teacher, $c->idioma, $c->level);
        });
        return $this->dataWithPagination($courses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CourseStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = \Auth::user()->id;
        $data['slug'] = str_replace(' ', '-', $data['name']) . '-' . $data['code'];
        $course = Course::create($data);
        $course->materials()->attach($data['materials']);
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
        $materials = $course->materials->pluck('id');
        unset($course->materials);
        $course->materials = $materials;
        $course->teacher_ = $course->teacher->fullName() . ' - ' . $course->teacher->num_id;
        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CourseUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseUpdateRequest $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->update_pivot($request->materials, 'materials');
        $course->update($request->validated());
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
    public function dataForRegister()
    {
        $teachers = \App\Models\Permisologia\Role::where('slug', '=', 'Profesor')
        ->findOrFail(2)->users()->orderBy('name', 'ASC')
        ->get(['id', 'name', 'last_name', 'num_id']);
        // $typestudents = \App\Models\TypeStudents::get(['id', 'name']);
        $idiomas = \App\Models\Idioma::get(['id', 'name']);
        $levels = \App\Models\Level::get(['id', 'name']);
        $classtypes = \App\Models\ClassType::get(['id', 'name']);
        $materials = \App\Models\Material::get(['id', 'name']);
        $teachers->each(function ($u) {
            $u->fullName = $u->fullName() . ' - ' . $u->num_id;
            unset($u->pivot);
        });
        return response()->json(compact('teachers', 'typestudents', 'idiomas', 'levels', 'classtypes', 'materials'));
    }
}
