<?php

namespace App\Http\Controllers\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ { Assistance, Notification };

class NotifyController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:notify_s,index')->only(['index']);
        $this->middleware('can:notify_s,store')->only(['store']);
        $this->middleware('can:notify_s,show')->only(['show']);
        $this->middleware('can:notify_s,update')->only(['update']);
        $this->middleware('can:notify_s,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $select = ['id', 'assistance_id', 'coordinator_id', 'state', 'observation', 'created_at', 'student_id'];
        if (\Auth::user()->iCan('notify_s', 'all')) {
            $data = Notification::dataForPaginate($select, function ($n) {
                if ($n->state === 0) {
                    $n->state = "<span class='label label-danger'>Rechazado</span>";
                } elseif ($n->state === 1) {
                    $n->state = "<span class='label label-success'>Aprobado</span>";
                } else {
                    $n->state = "<span class='label label-default'>No Respondido</span>";
                }

                $n->coordinator_id = $n->coordinator->fullName();
                $n->course = $n->assistance->course->code;
                $n->date = $n->created_at->format('Y/m/d h:i a');
                $n->teacher = $n->assistance->course->teacher->fullName();
                $student = $n->student->fullName();
                $n->motivo = $n->assistance->event->name;
                unset($n->assistance, $n->student);
                $n->student = $student;
            }, ['dir' => 'DESC']);
        } else {
            $data = Notification::orderBy(request()->order?:'id', request()->dir?:'DESC')
            ->search(request()->search)
            ->where('student_id', \Auth::user()->id)
            ->select($select)
            ->paginate(request()->num?:10);
            $data->each(function ($n) {
                if ($n->state === 0) {
                    $n->state = "<span class='label label-danger'>Rechazado</span>";
                } elseif ($n->state === 1) {
                    $n->state = "<span class='label label-success'>Aprobado</span>";
                } else {
                    $n->state = "<span class='label label-default'>No Respondido</span>";
                }

                $n->coordinator_id = $n->coordinator->fullName();
                $n->course = $n->assistance->course->code;
                $n->date = $n->created_at->format('Y/m/d h:i a');
                $n->teacher = $n->assistance->course->teacher->fullName();
                $student = $n->student->fullName();
                $n->motivo = $n->assistance->event->name;
                unset($n->assistance, $n->student);
                $n->student = $student;
            });
        }

        return $this->dataWithPagination($data);
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
            'coordinator_id' => 'required|numeric',
            'motivo' => 'required|numeric',
            'observation' => 'required|string'
        ],[],[
            'coordinator_id' => 'coordinador',
            'observation' => 'observación'
        ]);

        $assistance = Assistance::create([
            'course_id' => $request->id,
            'user_id' => \Auth::user()->id,
            'event_id' => $data['motivo'],
        ]);

        Notification::create([
            'assistance_id' => $assistance->id,
            'coordinator_id' => $data['coordinator_id'],
            'observation' => $data['observation'],
            'student_id' => \Auth::user()->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->student = $notification->assistance->user->fullName();
        $notification->course = $notification->assistance->course->code;
        $notification->date = $notification->created_at->format('Y/m/d h:i a');
        $notification->motivo = $notification->assistance->event->name;
        unset($notification->assistance);
        return response()->json($notification);
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
            'state' => 'required|numeric',
            'reschedule' => 'required_if:state,1|nullable|date'
        ],[],['state' => 'estado', 'reschedule' => 'reprogramar']);
        if ($data['state'] == 0) $data['reschedule'] = null;
        $notification = Notification::findOrFail($id);
        $notification->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->assistance->delete();
        $notification->delete();
    }
}
