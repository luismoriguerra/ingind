<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Restablecimiento de contraseña</h2>

		<div>
			Para restablecer su contraseña, rellene este formulario:: {{ URL::to('password/reset', array($token,$user['email'])) }}.<br/>
			Este enlace caducará en {{ Config::get('auth.reminder.expire', 60) }} minutos.
		</div>
	</body>
</html>
