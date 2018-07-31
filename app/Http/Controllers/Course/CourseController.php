<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ { Course, Idioma, Level, ClassType, Material, TypeStudents, Day };
use App\Models\Permisologia\Role;
use App\Http\Requests\ { CourseStoreRequest, CourseUpdateRequest };

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('onlyAjax');
        $this->middleware('can:courseManagement,index')->only(['index', 'dataForRegister']);
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
        $courses = Course::dataForPaginate(['id', 'code', 'name', 'teacher_id', 'idioma_id', 'level_id', 'max_students'], function ($c) {
            $c->teacher_id = $c->teacher->fullName();
            $c->idioma_id = $c->idioma->name;
            $c->level_id = $c->level->name;
            $c->cupos = $c->users()->count();
            unset($c->teacher, $c->idioma, $c->level, $c->users);
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
        $course->days()->attach($data['days']);
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
        $days = $course->days->pluck('id');
        $teacher = $course->teacher->fullName() . ' - ' . $course->teacher->num_id;
        $idioma = $course->idioma->name;
        $inscritos = $course->users()->count();
        unset($course->materials, $course->teacher, $course->idioma, $course->days);
        $course->teacher = $teacher;
        $course->materials = $materials;
        $course->days = $days;
        $course->idioma = $idioma;
        $course->cupos = $course->max_students - $inscritos;
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
        $course->update_pivot($request->days, 'days');
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
        $teachers = Role::where('slug', '=', 'Profesor')
        ->findOrFail(2)->users()->orderBy('name', 'ASC')
        ->get(['id', 'name', 'last_name', 'num_id']);
        $teachers->each(function ($u) {
            $u->text = $u->fullName() . ' - ' . $u->num_id;
            unset($u->pivot);
        });

        $typestudents = TypeStudents::get(['id', 'name']);
        $idiomas = Idioma::get(['id', 'name']);
        $levels = Level::get(['id', 'name']);
        $classtypes = ClassType::get(['id', 'name']);
        $materials = Material::get(['id', 'name']);
        $days = Day::get(['id', 'name']);

        return response()->json(compact('teachers', 'typestudents', 'idiomas', 'levels', 'classtypes', 'materials', 'days'));
    }

}
