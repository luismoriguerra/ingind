<h1>Hola {{ $email }}</h1>
 
<p>{{ $mensaje }}</p>

<p>Mi link para acceder a mi ubicación!</p>

<?php echo HTML::link( $url ); ?>

<p>Mi Qr facilitandote el acceso desde tu celular!</p>

<img src="<?php echo $message->embed($qr); ?>">


