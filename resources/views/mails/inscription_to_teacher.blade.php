<p>Dear teacher:</p> 

<p>On this e-mail you’ll find all the information to track your online classes and your students’ attendance. This platform is very important for recording the classes you do and will be your official ‘signature sheet’ for them.</p>

<p>Make sure that you and the students sign in at the same time.</p>

<p>Here you’ll find your students’ information so you help them to sign in. {{ url('/') }}</p>

<p><b>Language:</b> {{ $course->idioma->name }}.</p>
<p><b>Coordinator:</b> {{ $course->coordinator->fullName() }}.</p>
<p><b>Level:</b> {{ $course->level->name }}.</p>
<p><b>Start:</b> {{ $course->date_init }}.</p>

<p><b>Signed up:</b></p>
<ul>
	@foreach($course->users as $u)
	<li>{{ $u->fullName() }} - {{ ($u->type == 1) ? 'RUT' : 'Pasaporte' }}: {{ $u->num_id }}.</li>
	@endforeach
</ul>
