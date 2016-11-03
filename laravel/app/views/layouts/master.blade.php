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
            {{ HTML::style('lib/perfect-scrollbar/perfect-scrollbar.css') }}

            <?php echo HTML::style('lib/bootstrap-3.3.1/css/ionicons.min.css'); ?>
            {{ HTML::style('lib/datatables-1.10.4/media/css/dataTables.bootstrap.css') }}
            {{ HTML::style('css/admin/admin.css') }}
		    {{ HTML::script('lib/datatables-1.10.4/media/js/jquery.dataTables.js') }}
		    {{ HTML::script('lib/datatables-1.10.4/media/js/dataTables.bootstrap.js') }}
		    {{ HTML::script('js/utils.js') }}
            {{ HTML::script('lib/perfect-scrollbar/perfect-scrollbar.js') }}
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


            @include( 'chat' )
            



            </aside><!-- /.right-side -->
             
        </div><!-- ./wrapper -->

       @yield('formulario')
    </body>
	<script>

     /*   $('.').perfectScrollbar();*/
        $('.myscroll').perfectScrollbar({
            suppressScrollX : true
        });
        $('[data-toggle="tooltip"]').tooltip();

        $('ul.sidebar-menu li').each(function(indice, elemento) {
            htm=$(elemento).html();
            if(htm.split('<a href="{{ $valida_ruta_url }}"').length>1){
                $(elemento).addClass('active');
            }
        });

        show = function(){
        	$('.live-chat').css('display', 'block');
        }

        ocultar = function(object,element){
            $('.'+element).css('display', 'none');
        }

        nuevoMensaje = function(){
            $('.nuevomensaje').css('display', 'block');
        }

        abrirChat = function(object){
            $('.chatonline').css('display', 'block');
        }
    </script>
</html>
