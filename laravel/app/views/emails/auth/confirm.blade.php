<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de registro</title>
</head>
<body>
    <h1>Gracias por registrarte!</h1>

    <p>
        Sólo necesitamos que  <a href='{{ url("register/confirm/{$user['token']}") }}'>confirme su dirección de correo electrónico</a> rapidamente!
    </p>
</body>
</html>