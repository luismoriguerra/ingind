<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {{ trans('greetings.pinicio') }}
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li class="active">{{ trans('greetings.menu_inicio') }}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">                
                            <!-- Inicia contenido -->
                            
                            <!-- Finaliza contenido -->
                        </div>
                    </div>

                </section><!-- /.content -->
                <script>
                    $(document).ready(function() { 
                        $('#inicioModal').on('show.bs.modal', function (event) {

                        var modal = $(this); //captura el modal
                        modal.find('.modal-title').text('Responder');
                        $('#form_mensajes_modal [data-toggle="tooltip"]').css("display","none");
                        $("#form_mensajes_modal input[type='hidden']").remove();
                        
                    });
                    <?php if(Session::get('respuesta_id')!=1 and Session::get('respuesta_id')!=2 and Session::get('respuesta_id')!=3 ){?>
                        $('#inicioModal').modal({backdrop: 'static', keyboard: false});
                    <?php }?>
                    }); 
                    GrabarAuditoriaInicio=function(respuesta_id){
                        dataG={respuesta_id:respuesta_id};
                        if(respuesta_id==1){
                            window.location.href = "admin.ruta.asignartramite";
                        }
                        if(respuesta_id==2){
                           window.location.href = "admin.produccion.ordentrabajo";
                        }
                        if(respuesta_id==3){
                           window.location.href = "admin.reporte.listaproceso";
                        }
                        AuditoriaInicio.guardarAuditoriaInicio(dataG);
                    };
                    var AuditoriaInicio={
                        guardarAuditoriaInicio:function(dataG){
                            $.ajax({
                                url         : 'auditoriacuestionarioinicio/crear',
                                type        : 'POST',
                                cache       : false,
                                dataType    : 'json',
                                data        : dataG,
                                beforeSend : function() {
                                    $("body").append('<div class="overlay"></div><div class="loading-img"></div>');
                                },
                                success : function(obj) {
                                    if(obj.rst==1){
                                        msjG.mensaje('success',obj.msj,4000);
                                    }
                                    else{
                                        alert(obj.msj);
                                    }
                                    $(".overlay,.loading-img").remove();
                                },
                                error: function(){
                                    $(".overlay,.loading-img").remove();
                                    msjG.mensaje('danger','<b>Ocurrio una interrupción en el proceso,Favor de intentar nuevamente.',4000);
                                }
                            });
                                    },
                    };
                </script>
@stop
@section('formulario')
     @include( 'layouts.form.inicio' )
@stop