<h1>Hola {{ $email }}</h1>

<p>De : {{ $email2 }}</p>
<p>Acabo de agregarte a mi lista de contactos, favor de confirmar ingresando a la siguiente url:</p>

<?php echo url('check/validacontacto?email='.$email.'&hash='.$hash, $parameters = array(), $secure = null); ?>
