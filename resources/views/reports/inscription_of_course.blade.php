@extends('layouts.report')

@section('content')
<div class="row">
	<div class="pull-left">
		<img src="{{ asset('/img/logo.jpeg') }}" alt="Logo Empresa" height="100px">
	</div>
	<div class="pull-right">
		<span>Nro. Pág. 1</span>
	</div>
</div>
<div class="row">
	<div class="pull-left">
		<h3>Inscripción de Curso No. {{ $course->code }}.</h3>
	</div>
	<div class="pull-right">
		Fecha Emisión: {{ \Carbon::now()->format('d-m-Y') }}.
	</div>
</div>
<div class="row">
	<table>
		<tr>
			<th>Estudiante</th>
			<td>{{ $user->fullName() }}</td>
		</tr>
		<tr>
			<th>Idioma</th>
			<td>{{ $course->idioma->name }}</td>
		</tr>
		<tr>
			<th>Tipo de Clase</th>
			<td>{{ $course->class_type->name }}</td>
		</tr>
		<tr>
			<th>Nivel del Curso</th>
			<td>{{ $course->level->name }}</td>
		</tr>
		<tr>
			<th>Profesor</th>
			<td>{{ $course->teacher->fullName() }}</td>
		</tr>
		<tr>
			<th>Coordinador</th>
			<td>{{ $course->coordinator->fullName() }}</td>
		</tr>
		<tr>
			<th>Tipo de Estudiante</th>
			<td>{{ $course->type_student->name }}</td>
		</tr>
		<tr>
			<th>Empresa</th>
			<td>{{ optional($course->company)->name }}</td>
		</tr>
		<tr>
			<th>Estado del Curso</th>
			<td>{{ $course->coursestate->name }}</td>
		</tr>
		<tr>
			<th>Material a utilizar</th>
			<td>{{ $course->material->name }}</td>
		</tr>
		<tr>
			<th>Días Realización</th>
			<td>
				<?php $i = 0 ?>
				@foreach($course->days as $d)<?php $i++ ?>@if($i > 1), @endif{{ $d->day->name }}@endforeach
			</td>
		</tr>
		<tr>
			<th>Horarios</th>
			<td>
				<ul>
					@foreach($course->days as $d)
					<li>{{ $d->day->name }}: {{ $d->hour_start }} - {{ $d->hour_end }}</li>
					@endforeach
				</ul>
			</td>
		</tr>
	</table>
</div>
<div class="row">
	<div class="text-right">
		<b>Usuario que solicita:</b> {{ \Auth::user()->fullName() }}
	</div>
</div>
@endsection