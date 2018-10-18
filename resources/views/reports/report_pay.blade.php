@extends('layouts.report')

@section('content')
<div class="row">
	<div class="pull-left">
		<img src="{{ asset('/img/logo.jpeg') }}" alt="Logo Empresa" height="100px">
	</div>
	{{-- <div class="pull-right">
		<span>Nro. Pág. 1</span>
	</div> --}}
</div>
<div class="row">
	<div class="pull-left">
		<h3>Reporte de Clases para Reunión de Pago.</h3>
	</div>
	<div class="pull-right">
		Fecha Emisión: {{ \Carbon::now()->format('d-m-Y') }}.
	</div>
</div>
<div class="row">
	<div class="pull-left">
		Nombre del Profesor: <b>{{ $user->fullName() }}</b>.
	</div>
</div>
<div class="row">
	<table style="font-size: 14px;">
		<tr>
			<th>Fecha Ejecución</th>
			<th>Hora Inicio</th>
			<th>Hora Final</th>
			<th>Tiempo total</th>
			<th>Empresa</th>
			<th>Curso</th>
			<th>Alumno</th>
			<th>Idioma</th>
		</tr>
		@foreach($assistances as $a)
		<tr>
			<td>{{ $a->created_at->format('d-m-Y') }}</td>
			<td>{{ $a->created_at->format('H:i:s') }}</td>
			<td>{{ $a->finish_at->format('H:i:s') }}</td>
			<td>{{ $a->total }}</td>
			<td>{{ $a->course->company->name }}</td>
			<td>{{ $a->course->code }}</td>
			<td>
				@foreach($a->course->users as $u)
				{{ $u->fullName() }}
				@endforeach
			</td>
			<td>{{ $a->course->idioma->name }}</td>
		</tr>
		@endforeach
	</table>
</div>
<div class="row">
	<div class="pull-left">
		Total Horas: {{ $count_h }}.
	</div>
	<div class="pull-right">
		Total Alumnos: {{ $count_s }}.
	</div>
</div>
<div class="row">
	<div class="text-right">
		<b>Usuario que solicita:</b> {{ \Auth::user()->fullName() }}
	</div>
</div>
@endsection