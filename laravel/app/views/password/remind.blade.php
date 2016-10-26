<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">       
        <meta name="author" content="Jorge Salcedo (Shevchenko)">
        
        <link rel="shortcut icon" href="assets/ico/favicon.ico">
        <meta name="description" content="">
        <title>
                M. Independencia
        </title>
                {{ HTML::style('lib/font-awesome-4.2.0/css/font-awesome.min.css') }}
            {{ HTML::style('lib/bootstrap-3.3.1/css/bootstrap.min.css') }}
            {{ HTML::script('lib/jquery-2.1.3.min.js') }}
            {{ HTML::script('lib/jquery-ui-1.11.2/jquery-ui.min.js') }}
            {{ HTML::script('lib/bootstrap-3.3.1/js/bootstrap.min.js') }}
            {{ HTML::style('css/login/login.css') }}
            {{ HTML::script('js/login/login_ajax.js') }}
            {{ HTML::script('js/login/login.js') }}
    </head>

    <body  bgcolor="#FFF" onkeyup="return validaEnter(event,'btnSend');">
        <div id="mainWrap">
            <div id="loggit">
                <h1><i class="fa fa-lock"></i> MUN.INDEP. </h1>
                
                <h3 id="mensaje_ok" style="display:none" class="label-success">
                </h3>
                <h3 id="mensaje_error" style="display:none" class="label-danger">
                </h3>

                <h3 id="mensaje_inicio">Por Favor <strong>Ingresa su email</strong></h3>
                <form action="remind" id="sendEmail" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input class="form-control input-lg"  required placeholder="email" name="email" id="email" type="email">
                    <button type="button" id="btnSend" class="btn btn-primary btn-lg">Enviar recordatorio</button>
                </form>
        </div>
    </div>
</body>