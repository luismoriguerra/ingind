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
		<meta name="token" id="token" value="{{ csrf_token() }}">
        {{ HTML::style('css/login/login.css?v05') }}
        {{ HTML::style('lib/font-awesome-4.2.0/css/font-awesome.min.css') }}
        {{ HTML::style('lib/bootstrap-3.3.1/css/bootstrap.min.css') }}
        {{ HTML::script('lib/jquery-2.1.3.min.js') }}
        {{ HTML::script('lib/jquery-ui-1.11.2/jquery-ui.min.js') }}
        {{ HTML::script('lib/bootstrap-3.3.1/js/bootstrap.min.js') }}
        {{ HTML::script('js/login/login_ajax.js') }}
        {{ HTML::script('js/login/login.js') }}
	</head>

	<body  bgcolor="#FFF" onkeyup="return validaEnter(event,'btnIniciar');">
		<div id="mainWrap">
			<div id="loggit">
				<h2 class="titulo">{{-- <i class="fa fa-lock"></i> --}} MUN. INDEPENDENCIA</h2>
				<img src="img/logo_muni.png" class="img-circle logoPersonaje">
				{{-- {{ HTML::image('img/mindependencia.jpg', 'a picture', array('class' => 'logoPersonaje','class' => 'img-circle')) }} --}}
				<h3 id="mensaje_msj"  class="label-success">
				<?=	Session::get('msj'); ?>			
				</h3>
				
				<h3 id="mensaje_error" style="display:none" class="label-danger">			
				</h3>

	            <h3 id="mensaje_inicio">Por Favor <strong>Logeate</strong></h3>            
	        
			<form action="login/signin" id="logForm" method="post" class="form-horizontal">
				<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<div class="col-xs-12">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
								<input type="text" name="usuario" id="usuario" class="form-control input-md" placeholder="Usuario" autocomplete="off" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
								<input type="password" name="password" id="password" class="form-control input-md" placeholder="Password" autocomplete="off" required>
							</div>
						</div>
					</div>
					<div class="form-group formSubmit">
						<div class="col-sm-7">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember" checked autocomplete="off"> Mantener activa la session
								</label>
							</div>
						</div>
						<div class="col-sm-5 submitWrap">
							<button type="button" id="btnIniciar" class="btn btn-primary btn-md">Iniciar</button>				
						</div>
					</div>					
					<div class="load" align="center" style="display:none"><i class="fa fa-spinner fa-spin fa-3x"></i></div>	
				</div>
				</div>	
			</form>

			<div class="animate">
							<!-- <div class="col-md-7 "><a class="olvidaste" href="#">Olvidaste tu contraseÃ±a</a></div> -->
				<div class="col-md-6 col-sm-6 col-xs-6 text-left">{{-- <a class="olvidaste recuperar_pass" id="recuperar_pass" tipo="" data-toggle="modal" data-target="#myModal" style="cursor:pointer;">Recuperar </a --}}>
					 <a class="olvidaste recuperar_pass" style="cursor:pointer;" href="{{ url('password/remind') }}">Olvidé mi contraseña</a><br>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6 "> 
<!--					<div class="row btn-registrate">
						<a class="registrarse" href="{{ url('login/register') }}" class="text-center">Registrar Nuevo</a>
					</div>-->
				</div>
			</div>
		    {{-- <a href="{{ url('password/remind') }}">Olvidé mi contraseña</a><br>
		    <a href="{{ url('login/register') }}" class="text-center">Registrar un Nuevo usuario</a> --}}
		</div>
	</div>
</body>
