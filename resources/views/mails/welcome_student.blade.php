<p>Estimado {{ $user-> fullName() }},</p>

<p>Junto con saludarte queremos darte la bienvenida a tu curso online. La idea es que podamos registrar tus clases y que tú puedas verificarlas a través de un una herramienta moderna que permitirá tener control sobre las clases realizadas, esto actuará como una firma digital.</p>

<p>Haz click en este link: {{ url('/') }} para que puedas ingresar a tus datos. </p>

<p>
	<b>Usuario:</b> <u>{{ $user->email }}</u>
	<br>
	<b>Contraseña:</b> <u>{{ $user->password_ }}</u>
</p>
