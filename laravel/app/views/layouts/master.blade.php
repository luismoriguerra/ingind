<html lang="en">
	<head>
		<meta charset="utf-8">
        <meta name="token" id="token" value="{{ csrf_token() }}">
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
            {{ Html::style('lib/sweetalert-master/dist/sweetalert.css') }}

            <?php echo HTML::style('lib/bootstrap-3.3.1/css/ionicons.min.css'); ?>
            {{ HTML::style('lib/datatables-1.10.4/media/css/dataTables.bootstrap.css') }}
            <!--ARCHIVO EN CONFLICTO-->
            {{ HTML::style('css/admin/admin.css') }}
            {{ HTML::script('lib/datatables-1.10.4/media/js/jquery.dataTables.js') }}
            {{ HTML::script('lib/datatables-1.10.4/media/js/dataTables.bootstrap.js') }}
            {{ HTML::script('js/utils.js') }}
            {{ HTML::script('lib/perfect-scrollbar/perfect-scrollbar.js') }}
            {{ Html::script('lib/sweetalert-master/dist/sweetalert.min.js') }}

            {{-- Html::script('lib/gmaps/apigoogle.js') --}}
            {{-- Html::script('lib/gmaps/gmaps.js') --}}
            
            @include( 'admin.js.app' )
            {{--       @include( 'css/admin/chat' ) --}}
		@show

        <!-- <script async defer src="lib/google_maps/gmaps.js"></script> -->
        <!-- 
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="lib/gmaps/gmaps.js"></script> 
        -->

	</head>	

    <body class="skin-blue">
    <div id="msj" class="msjAlert"> </div>
        @include( 'layouts.admin_head' )

        <div class="wrapper row-offcanvas row-offcanvas-left">
            @include( 'layouts.admin_left' )

            <aside class="right-side">
            @yield('contenido')


            @include('templates/chat')
            



            </aside><!-- /.right-side -->
             
        </div><!-- ./wrapper -->

       @yield('formulario')
    </body>
    <?php
    
        $ruta=explode('.',Request::path());
        if(Request::path()!='admin.inicio' and (Auth::user()->rol_id==8 or Auth::user()->rol_id==9)){
            $opcion= Opcion::where('ruta','like','%'.$ruta[2])->first();
            
            $auditoria=new AuditoriaAcceso;
            $auditoria->persona_id=Auth::user()->id;
            $auditoria->rol_id=Auth::user()->rol_id;
            $auditoria->opcion_id=@$opcion->id;
            $auditoria->tipo=1;
            $auditoria->usuario_created_at=Auth::user()->id;
            $auditoria->ruta=$ruta[2];
            $auditoria->save();
        }
        
        $ssql="  SELECT m.id as m_id,m.contenido,m.titulo,md.id as dm_id
                          FROM mensajes m
                          LEFT JOIN mensajes_detalle md ON m.id=md.mensaje_id AND md.usuario_created_at=".Auth::user()->id." AND md.estado=1
			  WHERE DATE(m.created_at)=CURDATE() AND m.estado=1";
        $mensaje= DB::select($ssql);
        if(count($mensaje)==0){
            $mensaje=array(
                       (object) array('contenido'=>'','titulo'=>'','dm_id'=>'','m_id'=>'')
                    );
                    
        } 
        ?>;
	<script>
        var MensajeG9973=0;
        $(document).ready(function() { 

        var contenido='<?php  echo $mensaje[0]->contenido?>';
        var titulo='<?php  echo $mensaje[0]->titulo?>';
        var dm_id='<?php  echo $mensaje[0]->dm_id?>';    
        var id='<?php   echo $mensaje[0]->m_id?>';
                        
        if( (dm_id==null || dm_id=='') && id!='' ){
                
                $('#mensajeModal').on('show.bs.modal', function (event) {
                    MensajeG9973=id;
                    $("#form_mensajes_modal #contenido").html(contenido);
                        var modal = $(this); //captura el modal
                        modal.find('.modal-title').text(titulo);
                        $('#form_mensajes_modal [data-toggle="tooltip"]').css("display","none");
                        $("#form_mensajes_modal input[type='hidden']").remove();
                        
                        modal.find('.modal-footer .btn-primary').text('Confirmar Lectura');
                        modal.find('.modal-footer .btn-primary').attr('onClick','RegistrarMensajeVisto('+MensajeG9973+');');
                        
                });

                $('#mensajeModal').on('hide.bs.modal', function (event) {
//               $('#form_mensajes_modal input').val('');
                });
                $("#mensajeModal").modal({
                        keyboard: false,
                        backdrop: false
                    });
             
        }
        });   
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
    </script>
</html>
