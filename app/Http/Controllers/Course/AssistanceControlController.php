<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;

class AssistanceControlController extends Controller
{

    public function __construct()
    {
        $this->middleware('onlyAjax');
        $this->middleware('can:assistanceControl,index')->only(['index']);
        // $this->middleware('can:assistanceControl,show')->only(['show']);
        // $this->middleware('can:assistanceControl,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = \Auth::user()->id;
        $courses = \App\User::findOrFail(15)->courses()
        ->orderBy($request->order?:'id', $request->dir?:'ASC')
        ->where('code', 'LIKE', "%{$request->search}%")
        ->orWhere('courses.name', 'LIKE', "%{$request->search}%")
        ->Where('course_user.user_id', '=', 15)
        ->paginate($request->num?:10);
        
        $courses->each(function ($c) {
            $c->teacher_id = $c->teacher->fullName();
            $c->idioma_id = $c->idioma->name;
            $c->level_id = $c->level->name;
            $c->user_class = 0;
            unset($c->class_type_id, $c->date_end_at, $c->date_inscription_end_at,
                $c->date_inscription_start_at, $c->date_start_at,
                $c->hour_end, $c->hour_start, $c->max_students,
                $c->slug, $c->user_id, $c->teacher,
                $c->idioma, $c->level, $c->pivot);
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
        //
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
        //
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
}
