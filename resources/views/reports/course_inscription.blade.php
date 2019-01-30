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
		<h3>Cursos Inscritos.</h3>
	</div>
	<div class="pull-right">
		Fecha Emisión: {{ \Carbon::now()->format('d-m-Y') }}.
	</div>
</div>
<div class="row">
	<table style="font-size: 14px;">
		<tr>
			<th>Código del Curso</th>
			<th>Fecha de Inicio</th>
			<th>Alumno</th>
			<th>Coordinador</th>
			<th>Profesor</th>
			<th>Idioma</th>
			<th>Tipo de Clase</th>
			<th>Estado</th>
		</tr>
		@foreach($user->coursesStudent as $c)
		<tr>
			<td>{{ $c->code }}</td>
			<td>{{ $c->date_init }}</td>
			<td>{{ $user->fullName() }}</td>
			<td>{{ $c->coordinator->fullName() }}</td>
			<td>{{ optional($c->teacher)->fullName() }}</td>
			<td>{{ $c->idioma->name }}</td>
			<td>{{ $c->class_type->name }}</td>
			<td>{{ $c->coursestate->name }}</td>
		</tr>
		@endforeach
	</table>
</div>
<div class="row">
	<div class="text-right">
		<b>Usuario que solicita:</b> {{ \Auth::user()->fullName() }}
	</div>
</div>
@endsection
