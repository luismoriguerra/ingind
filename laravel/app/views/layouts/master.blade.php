<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
		
		@section('autor')
		<meta name="author" content="Jorge Salcedo (Shevchenko)">
		@show
		
		<link rel="shortcut icon" href="favicon.ico">

		@section('descripcion')
		<meta name="description" content="">
		@show
		<title>
			@section('titulo')
				M. Independencia
			@show
		</title>


		@section('includes')
            {{ HTML::style('lib/bootstrap-3.3.1/css/bootstrap.min.css') }}
            {{ HTML::style('lib/font-awesome-4.2.0/css/font-awesome.min.css') }}
			{{ HTML::script('lib/jquery-2.1.3.min.js') }}
			{{ HTML::script('lib/jquery-ui-1.11.2/jquery-ui.min.js') }}
			{{ HTML::script('lib/bootstrap-3.3.1/js/bootstrap.min.js') }}

            <?php echo HTML::style('lib/bootstrap-3.3.1/css/ionicons.min.css'); ?>
            {{ HTML::style('lib/datatables-1.10.4/media/css/dataTables.bootstrap.css') }}
            {{ HTML::style('css/admin/admin.css') }}
		    {{ HTML::script('lib/datatables-1.10.4/media/js/jquery.dataTables.js') }}
		    {{ HTML::script('lib/datatables-1.10.4/media/js/dataTables.bootstrap.js') }}
		    {{ HTML::script('js/utils.js') }}
            @include( 'admin.js.app' )
		@show
	</head>	

    <body class="skin-blue">
    <div id="msj" class="msjAlert"> </div>
        @include( 'layouts.admin_head' )

        <div class="wrapper row-offcanvas row-offcanvas-left">
            @include( 'layouts.admin_left' )

            <aside class="right-side">
            @yield('contenido')


            <a class="open-chat-button tooltips" onClick="show()" href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="" data-original-title="Info Chat"><i class="fa fa-wechat"></i></a>
                
                <a class="open-chat-button-active tooltips" href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="" data-original-title="Info Chat"><i class="fa fa-wechat"></i></a>

                <div class="live-chat">
                    <form action="#" id="form-chat" class="sky-form">
                            <header>Chat<button type="button" class="close-chat-button minimize-chat-button" aria-hidden="true"><i class="fa fa-minus"></i></button></header>                            
                            <fieldset>                  
                                <section>
                                    <div class="row">
	                                    <div class="col-md-3 col-sm-3 col-xs-3 imagenPerfil">
	                                    	<img src="{{asset('img/user/u5.jpg')}}" style="height: 40px;width: 40px;border-radius: 50px">
	                                    </div>
	                                    <div class="col-md-9 col-sm-9 col-xs-9 datosPerfil">
	                                    	<h3>Pedro Williams Solano Francia</h3>
	                                    	<p>Analista Programador</p>
	                                    </div>
                                    </div>
                                </section>

                                <section>
                                	<div class="col-md-12 col-sm-12 col-xs-12 left">
                                        <div class="imagenPerfil">
                                            <img src="http://www.e-quipu.pe/dinamic/perfil/63x75/avatar_vqrzZZ-H-5MsYAunGQzJdaTeC.jpg" class="img-circle" style="height:40px;width:40px">
                                        </div>
                                                                                  
                                        <div class="datosPerfil">
                                            <h3 class="nombre">
                                               Fabio Franco Venero Carra
                                            </h3>
                                            <p>Analista Programador</p>
                                        </div>
                                    </div>
                                </section>
                                
                               
                            </fieldset>
                            <footer>
                                <button type="submit" class="btn-u">Enter</button>
                            </footer>
                        </form>
                    <!-- Default Panel -->
                    <div class="panel panel-u" style="display:none">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-comment"></i> Talk to us!
                                <button type="button" class="close-chat-button" aria-hidden="true"><i class="fa fa-times"></i></button>
                                <button type="button" class="minimize-chat-button" aria-hidden="true"><i class="fa fa-minus"></i></button>
                            </h3>
                        </div>
                        <div class="panel-body c-body">
                            <div class="alert alert-warning" style="margin:15px">
                               <strong>Hello my dear!</strong> A coordinator will be attending in a few minutes. Just wait or leave us a message and we will soon answer...
                            </div>                              
                        </div>
                        <div class="panel-footer">
                            <form class="sky-form">
                                <label class="input">
                                    <button id="btn-send" class="btn-u icon-append"><i class="glyphicon glyphicon-play"></i></button>
                                    <input type="hidden" id="chat_id">
                                    <input type="text" id="in-message" placeholder="Type here...">
                                </label>
                            </form>
                            
                        </div>
                    </div>
                    <!-- End Default Panel -->
                </div>



            </aside><!-- /.right-side -->
             
        </div><!-- ./wrapper -->

       @yield('formulario')
    </body>
	<script>
        $('ul.sidebar-menu li').each(function(indice, elemento) {
            htm=$(elemento).html();
            if(htm.split('<a href="{{ $valida_ruta_url }}"').length>1){
                $(elemento).addClass('active');
            }
        });

        show = function(){
        	$('.live-chat').css('display', 'block');
        }
    </script>
</html>
