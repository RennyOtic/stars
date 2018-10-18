<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Assistance, Course };
use App\Models\Permisologia\Role;
use App\User;

class ReportsController extends Controller
{

	public function __construct()
	{
		$this->middleware('can:report,inscription')->only(['pdf_inscription']);
		$this->middleware('can:report,course_inscription')->only(['pdf_course_inscription']);
		$this->middleware('can:report,assistance')->only(['assistance']);
	}

	public function pdf_inscription($course_id, $user_id)
	{
		$course = Course::findOrFail($course_id);
		$user = User::findOrFail($user_id);
		$pdf = \PDF::loadView('reports.inscription_of_course', compact('course', 'user'));
		return $pdf->download('Inscripción del Curso: ' . $user->fullName() . ' - ' . \Carbon::now()->format('Y-m-d') . '.pdf');
	}

	public function pdf_course_inscription($user_id)
	{
		$user = User::findOrFail($user_id);
		$pdf = \PDF::loadView('reports.course_inscription', compact('user'));
		return $pdf->download('Cursos Inscritos ' . $user->fullName() . ' - ' . \Carbon::now()->format('Y-m-d') . '.pdf');
	}

	public function assistance($course_id, $user_id)
	{
		$user = User::findOrFail($user_id);
		$course = Course::findOrFail($course_id);
		$assistances = Assistance::where('user_id', $user_id)
		->where('course_id', $course_id)
		->whereIn('event_id', [1])
		->get();
		$count = 0;
		foreach ($assistances as $a) {
			if ($a->finish_at == null) {
				$a->finish_at = $a->assistances_control->last()->created_at;
			}
			$time = $a->created_at->diffInSeconds($a->finish_at);
			$a->total = gmdate('H:i:s', $time);
			$count += $time;
		}
		$count = gmdate('H:i:s', $count);
		$pdf = \PDF::loadView('reports.assistance', compact('assistances', 'user', 'course', 'count'));
		return $pdf->download('Asistencias al Curso: ' . $user->fullName() . ' - ' . \Carbon::now()->format('Y-m-d') . '.pdf');
	}

	public function pdf_course_teacher($user_id)
	{
		$user = User::findOrFail($user_id);
		$count = 0;
		foreach ($user->courses as $c) {
			$count += $c->users->count();
		}
		$pdf = \PDF::loadView('reports.course_teacher', compact('user', 'count'));
		return $pdf->download('Cursos por Profesor: ' . $user->fullName() . ' - ' . \Carbon::now()->format('Y-m-d') . '.pdf');
	}

	public function dataTopdf_pay()
	{
		$teachers = Role::where('slug', '=', 'Profesor')
        ->findOrFail(2)->users()->orderBy('name', 'ASC')
        ->get(['id', 'name', 'last_name', 'num_id']);
        $teachers->each(function ($u) {
            $u->text = $u->fullName() . ' - ' . $u->num_id;
            unset($u->pivot, $u->name, $u->last_name, $u->num_id);
        });
        return response()->json(compact('teachers'));
	}

	public function pdf_pay_teacher($user_id)
	{
		$date_init = (request()->date_init) ? \Carbon::parse(request()->date_init) : \Carbon::now();
		$date_end = (request()->date_end) ? \Carbon::parse(request()->date_end) : \Carbon::now();
		$user = User::findOrFail($user_id);
		$assistances = Assistance::where('user_id', $user_id)
		->whereIn('event_id', [1])
		->whereBetween('finish_at', [$date_init->format('Y-m-d H:i:s'), $date_end->format('Y-m-d 23:59:59')])
		->get();
		$count_h = 0;
		$count_s = [];
		foreach ($assistances as $a) {
			if ($a->finish_at == null) {
				$a->finish_at = $a->assistances_control->last()->created_at;
			}
			$time = $a->created_at->diffInSeconds($a->finish_at);
			$a->total = gmdate('H:i:s', $time);
			$count_h += $time;
			foreach ($a->course->users->pluck('id')->toArray() as $a) {
				array_push($count_s, $a);
			}
		}
		$count_s = count(array_unique($count_s));
		$count_h = gmdate('H:i:s', $count_h);
		$pdf = \PDF::loadView('reports.report_pay', compact('user', 'assistances', 'count_h', 'count_s'));
		return $pdf->download('Reporte de Pago: ' . $user->fullName() . ' - ' . \Carbon::now()->format('Y-m-d') . '.pdf');
	}

}