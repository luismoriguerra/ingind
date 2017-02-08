<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    {{ HTML::style('lib/datepicker.css') }}
    {{ HTML::script('lib/bootstrap-timepicker/js/bootstrap-timepicker.js') }}

{{--     {{ HTML::script('//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js') }} --}}
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
{{--     {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }} --}}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.produccion.js.reporteotusuario_ajax' )
    @include( 'admin.produccion.js.reporteotusuario' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')

<style type="text/css">
    .btn-yellow{
        color: #0070ba;
        background-color: ghostwhite;
        border-color: #ccc;
        font-weight: bold;
    }

    .yellow-fieldset{
        max-width: 100% !important;
        border: 3px solid #999;
        padding:10px 50px 10px 9px;
        border-radius: 10px; 
    }

    .margin-top-10{
         margin-top: 10px;   
    }
</style>
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mis Actividades Personales
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Actividad Personal</a></li>
                <li class="active">Mis Actividades</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="box-body">
                            <form name="form_persona_detalle" id="form_persona_detalle" method="POST" action="">
                                    <div id="bandeja_detalle" class="row form-group">
                                        <div class="col-sm-12 hidden">
                                            <div class="col-md-12 col-sm-12">
                                            <h3><span id="txt_titulo2">Usuario</span>
                                            <small>
                                                <i class="fa fa-angle-double-right fa-lg"></i>
                                                <span id="texto_fecha_creacion2">:</span>
                                            </small>
                                            </h3>
                                                </div>
                                        </div>
                                        <div class="col-sm-12">
                                             <fieldset class="yellow-fieldset">
                                                <div class="col-sm-2" style="padding-top: 5px">
                                                    <span>Tiempo Total: </span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="txt_totalh" name="txt_totalh" readonly="readonly">
                                                </div>                                                
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-12 margin-top-10">
                                            <input type="hidden" id="usuario_id" name="usuario_id">
                                            <div class="col-md-4 col-sm-4">
                                                <label class="control-label">Nombre:</label>
                                                <input type="text" class="form-control" id="txt_persona" readonly>
                                            </div>
                                             <div class="col-md-4 col-sm-4">
                                                <label class="control-label">Rango de Fechas:</label>
                                                <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                                             </div>
                                            <div class="col-md-1 col-sm-1">                            
                                                <label class="control-label" style="color: white">aaaaa</label>
                                                <input type="button" class="btn btn-info" id="generar" name="generar" value="Productividad">
                                             </div>
                                            <div class="col-md-1 col-sm-2" style="padding:24px">
                                                <a class='btn btn-success btn-md' id="btnexport" name="btnexport"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
                                            </div>
                                        </div>
                            </form>

                               <div class="col-sm-12">
                                  <div class="box-body table-responsive">
                                     <table id="t_ordenest" class="table table-bordered">
                                        <thead>
                                             <tr>
                                                 <th>Actividad</th>
                                                 <th>Fecha Inicio</th>
                                                 <th>Fecha Fin</th>
                                                 <th>Tiempo Transcurrido</th>
                                                 <th>Formato</th>
                                             </tr>
                                        </thead>
                                        <tbody id="tb_ordenest">
                                        </tbody>
                                     </table>
                                    </div>
                                </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
{{--      @include( 'admin.mantenimiento.form.cargo' ) --}}
@stop
