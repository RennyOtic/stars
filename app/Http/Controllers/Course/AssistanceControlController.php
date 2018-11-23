<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ { Course, EventAssistance, Assistance, AssistancesControl };
use App\User;
use App\Models\Permisologia\Role;

class AssistanceControlController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:assistanceControl,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:assistanceControl,store')->only(['store']);
        $this->middleware('can:assistanceControl,update')->only(['update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (\Auth::user()->iCan('assistanceControl', 'showDataInscription')) {
            $courses = User::findOrFail(\Auth::user()->id)->courses()
            ->orderBy($request->order?:'id', $request->dir?:'DESC')
            ->where('code', 'LIKE', "%{$request->search}%")
            ->select('id', 'code', 'idioma_id', 'level_id', 'teacher_id', 'coursestate_id')
            ->paginate($request->num?:10);
        } elseif (\Auth::user()->iCan('assistanceControl', 'showDataTeacher')) {
            $courses = Course::orderBy($request->order?:'id', $request->dir?:'DESC')
            ->where('teacher_id', \Auth::user()->id)
            ->where('code', 'LIKE', "%{$request->search}%")
            ->select('id', 'code', 'idioma_id', 'level_id', 'teacher_id', 'coursestate_id', 'teacher_id')
            ->paginate($request->num?:10);
        }

        $courses->each(function ($c) {
            $c->teacher_id = $c->teacher->fullName();
            $c->idioma_id = $c->idioma->name;
            $c->level_id = $c->level->name;
            $c->coursestate_id = $c->coursestate->name;
            unset($c->class_type_id, $c->company_id, $c->coordinator_id, $c->coursestate, $c->idioma, $c->level, $c->pivot, $c->material_id, $c->teacher, $c->type_student_id, $c->user_id);
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
        if ($request->event_id == 1) {
            $data = $this->validate($request, [
                'course_id' => 'required|numeric',
                'event_id' => 'required|numeric'
            ],[],['course_id' => 'curso', 'event_id' => 'evento']);
            $assistance = Assistance::create([
                'course_id' => $data['course_id'],
                'event_id' => $data['event_id'],
                'user_id' => \Auth::user()->id,
            ]);
            return response()->json($assistance->id);
        } elseif ($request->event_id == 2) {
            $data = $this->validate($request, ['assistance_id' => 'required|numeric', ]);
            $assistance = AssistancesControl::create([
                'assistance_id' => $data['assistance_id'],
                'user_id' => \Auth::user()->id,
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
        //
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
        $data = $this->validate($request, ['event_id' => 'required|numeric'],[],['event_id' => 'evento']);
        if ($data['event_id'] == 3) {
            Assistance::findOrFail($id)->update(['finish_at' => \Carbon::now()]);
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
        //
    }

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister(Request $request)
    {
        $course = Course::findOrFail($request->id);
        if (\Auth::user()->iCan('assistanceControl', 'mStudent')) { // alumno
            if ($course->users()->where('id', '=', \Auth::user()->id)->count() == 0) return;
        } elseif (\Auth::user()->iCan('assistanceControl', 'mTeacher')) { // profesor
            if ($course->teacher_id !== \Auth::user()->id) return;
        }
        $now = date('w') + 1;
        $teacher = $course->teacher->fullName() . ' - ' . $course->teacher->num_id;
        $idioma = $course->idioma->name;
        unset($course->teacher, $course->idioma, $course->days);
        $course->teacher = $teacher;
        $course->idioma = $idioma;

        $coordinators = Role::where('slug', '=', 'Coordinador')->first()->users()->orderBy('name', 'ASC')
        ->get(['id', 'name', 'last_name', 'num_id']);
        $coordinators->each(function ($u) {
            $u->fullName = $u->fullName() . ' - ' . $u->num_id;
            unset($u->pivot, $u->name, $u->last_name, $u->num_id);
        });

        if (\Auth::user()->iCan('assistanceControl', 'showTeacher')) { // profesor
            $eventassistance = EventAssistance::where('id', '>', 3)->get();
        } elseif (\Auth::user()->iCan('assistanceControl', 'showStudent')) { // alumno
            $eventassistance = EventAssistance::where('id', '>', 5)->get();
        }

        if ($request->assistance_id) {
            $state = Assistance::findOrFail($request->assistance_id)
            ->where('course_id', $request->id)
            ->where('user_id', \Auth::user()->id)
            ->where('finish_at', null)
            ->first();
        }

        return response()->json(compact('course', 'state', 'coordinators', 'eventassistance'));
    }
}
