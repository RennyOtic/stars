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
		<h3>Asistencias al Curso.</h3>
	</div>
	<div class="pull-right">
		Fecha Emisión: {{ \Carbon::now()->format('d-m-Y') }}.
	</div>
</div>
<div class="row">
	<div class="pull-left">
		Nombre del Alumno: {{ $user->fullName() }}.
	</div>
	<div class="pull-right">
		Número Curso: {{ $course->code }}.
	</div>
</div>
<div class="row">
	<table style="font-size: 14px;">
		<tr>
			<th>Fecha Ejecución</th>
			<th>Hora Inicio</th>
			<th>Hora Final</th>
			<th>Tiempo total</th>
		</tr>
		@foreach($assistances as $a)
		<tr>
			<td>{{ $a->created_at->format('d-m-Y') }}</td>
			<td>{{ $a->created_at->format('H:i:s') }}</td>
			<td>{{ $a->finish_at->format('H:i:s') }}</td>
			<td>{{ $a->total }}</td>
		</tr>
		@endforeach
	</table>
</div>
<div class="row">
	<div class="pull-left">
		Total Horas: {{ $count }}.
	</div>
	<div class="pull-right">
		<b>Usuario que solicita:</b> {{ \Auth::user()->fullName() }}
	</div>
</div>
@endsection