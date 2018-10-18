<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ { Course, Idioma, Level, ClassType, Material, TypeStudents, Day, Company, CourseDay, CourseState };
use App\Models\Permisologia\Role;
use App\Http\Requests\ { CourseStoreRequest, CourseUpdateRequest };

class CourseController extends Controller
{

    public function __construct()
    {
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
        $select = ['id', 'code', 'teacher_id', 'idioma_id', 'level_id', 'coursestate_id'];
        $courses = Course::dataForPaginate($select, function ($c) {
            $c->teacher_id = $c->teacher->fullName();
            $c->idioma_id = $c->idioma->name;
            $c->level_id = $c->level->name;
            $c->cupos = $c->users()->count();
            $c->coursestate_id = $c->coursestate->name;
            unset($c->teacher, $c->idioma, $c->level, $c->users, $c->coursestate);
        }, ['dir' => 'desc']);
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
        $data['slug'] = $data['code'] . '-' . $data['user_id'];
        $course = Course::create($data);
        foreach ($data['days'] as $d) {
            CourseDay::create([
                'course_id' => $course->id,
                'day_id' => $d['day_id'],
                'hour_start' => $d['hour_start'],
                'hour_end' => $d['hour_end'],
            ]);
        }
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
        $course->days->each(function ($d) {
            $d->name = $d->day->name;
            $d->day_id = $d->day->id;
            unset($d->day);
        });
        $teacher = $course->teacher->fullName() . ' - ' . $course->teacher->num_id;
        $idioma = $course->idioma->name;
        unset($course->teacher, $course->idioma, $course->coordinator);
        $course->teacher = $teacher;
        $course->idioma = $idioma;
        $course->user_class = 0;
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
        $data = $request->validated();
        $course = Course::findOrFail($id);
        $data['slug'] = $data['code'] . '-' . \Auth::user()->id;
        $course->update($data);
        $courseday = CourseDay::where('course_id', '=', $course->id)->pluck('id')->toArray();
        foreach ($data['days'] as $d) {
            if (isset($d['id'])) {
                CourseDay::findOrFail($d['id'])->update([
                    'hour_start' => $d['hour_start'],
                    'hour_end' => $d['hour_end'],
                ]);
                $courseday = array_diff($courseday, [$d['id']]);
            } else {
                CourseDay::create([
                    'course_id' => $course->id,
                    'day_id' => $d['day_id'],
                    'hour_start' => $d['hour_start'],
                    'hour_end' => $d['hour_end'],
                ]);
            }
        }
        foreach ($courseday as $c) {
            CourseDay::findOrFail($c)->delete();
        }
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
            unset($u->pivot, $u->name, $u->last_name, $u->num_id);
        });
        $coordinators = Role::where('slug', '=', 'Coordinador')
        ->findOrFail(4)->users()->orderBy('name', 'ASC')
        ->get(['id', 'name', 'last_name', 'num_id']);
        $coordinators->each(function ($u) {
            $u->text = $u->fullName() . ' - ' . $u->num_id;
            unset($u->pivot, $u->name, $u->last_name, $u->num_id);
        });

        $coursestates = CourseState::get(['id', 'name']);
        $typestudents = TypeStudents::get(['id', 'name']);
        $idiomas = Idioma::get(['id', 'name']);
        $levels = Level::get(['id', 'name']);
        $classtypes = ClassType::get(['id', 'name']);
        $materials = Material::get(['id', 'name']);
        $days = Day::get(['id', 'name']);
        $companies = Company::get(['id', 'name', 'rut']);
        $companies->each(function ($c) {
            $c->text = $c->name . ' - ' . $c->rut;
            unset($c->pivot, $c->name, $c->rut);
        });

        return response()->json(compact('teachers', 'typestudents', 'idiomas', 'levels', 'classtypes', 'materials', 'days', 'coordinators', 'companies', 'coursestates'));
    }

}
