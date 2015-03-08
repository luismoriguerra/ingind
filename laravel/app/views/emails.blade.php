
<h1>Hola, {{ $email }}</h1>
 
<p>Felicitaciones ud ahora pertenece a Ubicame.</p>
<p>Le damos la bienvenida a Ubicame. Gracias por que registrarse y perternecer a la mejor app de servicios de ubicación.</p>
<p>Hacer click en el siguiente enlace para validar su Email:</p>

<?php echo url('check/confirmacion?email='.$email.'&hash='.$hash, $parameters = array(), $secure = null); ?>
