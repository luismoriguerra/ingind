<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent

    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.reporte.js.cump_area_ajax' )
    @include( 'admin.ruta.js.ruta_ajax' )
    @include( 'admin.ruta.js.crear' )
    @include( 'admin.ruta.js.proceso' )
    
    @include( 'admin.ruta.js.microproceso' )
    @include( 'admin.ruta.js.microproceso_ajax' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Crear Ruta del Proceso - Trámite
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Ruta</a></li>
            <li class="active">Crear</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- Inicia contenido -->
                <div class="box">      
                <form id="form_crear" name="form_crear" method="POST" action="">
                    
                    <select style="display:none" class="form-control" name="slct_estados" id="slct_estados">
                        <option value>.::TODOS::.</option>
                        <option value="1">Producción</option>
                        <option value="2">Pendiente</option>
                    </select>
                    <input type="hidden" id="tipo_flujo" name="tipo_flujo" value="1">
                    <div class="box-body table-responsive">
                        <table id="t_crear" class="table table-bordered table-hover">


                           <thead>

                                <tr>

                                <th colspan="5" style="text-align:center;background-color:#A7C0DC;"><h2>Crear Ruta del Proceso - Trámite</h2></th>

                                </tr>
                                <tr></tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr></tr>
                                </tfoot>
                            </table>

                        <a class='btn btn-primary btn-sm' id="btn_nuevo">
                            <i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo
                        </a>
                    </div><!-- /.box-body -->
                    </form>
                    <form name="form_ruta_flujo" id="form_ruta_flujo" method="POST" action="">
                        <div class="row form-group" style="display:none">
                            <div class="col-sm-12">
                                <h1><span id="txt_titulo">Nueva Ruta del Proceso</span>
                                <small>
                                    <i class="fa fa-angle-double-right fa-lg"></i>
                                    <span id="texto_fecha_creacion">Fecha Creación:</span>
                                    <span id="fecha_creacion"></span>
                                </small>
                                </h1>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <label class="control-label">Dueño del Proceso:</label>
                                    <input class="form-control" type="text" id="txt_persona" name="txt_persona" readonly>
                                </div>
                                <div class="col-sm-5">
                                    <label class="control-label">Proceso:</label>
                                    <select class="form-control" name="slct_flujo_id" id="slct_flujo_id">
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">Area del Dueño del Proceso:</label>
                                    <select class="form-control" name="slct_area_id" id="slct_area_id" disabled>
                                    </select>
                                </div>
                                <!--div class="col-sm-2">
                                    <label class="control-label"># Ok:</label>
                                    <input class="form-control" type="text" id="txt_ok" name="txt_ok" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label"># Error:</label>
                                    <input class="form-control" type="text" id="txt_error" name="txt_error" readonly>
                                </div-->
                            </div>                                        
                        </div>
                        <div class="row form-group" style="display:none">
                            <div class="col-sm-12">
                                <!-- Custom Tabs -->
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs logo modal-header">
                                        <li class="logo active">
                                            <a href="#tab_1" data-toggle="tab">
                                                <button class="btn btn-primary btn-sm"><i class="fa fa-edit fa-lg"></i> </button>
                                                RUTA DEL PROCESO
                                            </a>
                                        </li>
                                        <li class="logo">
                                            <a href="#tab_2" data-toggle="tab">
                                                <button class="btn btn-primary btn-sm"><i class="fa fa-search-plus fa-lg"></i> </button>
                                                ADICIONAR PROCESOS
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="tab_1">
                                            <div class="box-body table-responsive">
                                                <table id="areasasignacion" class="table table-bordered" style="min-height:300px">
                                                    <thead> 
                                                        <tr class="head">
                                                            <th style="width:450px !important;min-width: 200px !important;" > 
                                                                <a id="btn_adicionar_ruta_detalle" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-plus-square fa-lg"></i>
                                                                </a>
                                                                <a   id="btn_adicionar_micro_proceso" class="btn btn-info btn-sm" title="Micro Proceso">
                                                                    <i class="fa fa-plus-square fa-lg"></i>
                                                                </a>
                                                            </th>
                                                            <th class="eliminadetalleg" style="min-width:1000px important!;">[]</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="body">
                                                            <td>
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr><th colspan="2">
                                                                            <select class="form-control" name="slct_area_id_2" id="slct_area_id_2">
                                                                            </select>
                                                                        </th></tr>
                                                                        <tr class="head">
                                                                            <th style="width:110px;">#</th>
                                                                            <th>Area</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tb_rutaflujodetalleAreas">
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="head">
                                                            <th>#</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div><!-- /.table responsive -->
                                        </div><!-- /.tab pane 1 -->

                                        <div class="tab-pane" id="tab_2">
                                            <div class="col-sm-12">
                                                <div class="col-sm-4">
                                                    <label class="control-label">Area:</label>
                                                    <select class="form-control" name="slct_area_id_r" id="slct_area_id_r" multiple>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Rango de Fechas:</label>
                                                    <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="control-label">Estado:</label>
                                                    <select class="form-control" name="slct_estado_id" id="slct_estado_id" multiple>
                                                    <option value="1">Producción</option>
                                                    <option value="2">Pendiente</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label class="control-label"></label>
                                                    <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="Mostrar">
                                                </div>
                                            </div>
                                            <div class="box-body table-responsive">
                                                <table id="t_reporte" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre del proceso</th>
                                                            <th>Dueño del Proceso</th>
                                                            <th>Área del dueño</th>
                                                            <th>N° de Áreas de la ruta</th>
                                                            <th>N° de Pasos de la ruta</th>
                                                            <th>Tiempo total de la ruta</th>
                                                            <th>Fecha Creación</th>
                                                            <th>Fecha Producción</th>
                                                            <th>N° Tramites</th>
                                                            <th> [ ] </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb_reporte">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="box-body table-responsive">
                                                <table id="areasasignacion_aux" class="table table-bordered" style="min-height:300px">
                                                    <thead> 
                                                        <tr class="head">
                                                            <th style="width:450px !important;min-width: 200px !important;" > 
                                                                <a id="btn_adicionar_ruta_detalle_aux" class="btn btn-primary btn-sm">
                                                                    Adicionar Ruta Proceso<i class="fa fa-plus-square fa-lg"></i>
                                                                </a>
                                                            </th>
                                                            <th class="eliminadetalleg" style="min-width:1000px important!;">[]</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="body">
                                                            <td>
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr><th colspan="2">
                                                                            
                                                                        </th></tr>
                                                                        <tr class="head">
                                                                            <th style="width:110px;">#</th>
                                                                            <th>Area</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tb_rutaflujodetalleAreas_aux">
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="head">
                                                            <th>#</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div><!-- /.table responsive -->
                                        </div><!-- /.tab pane 2 -->

                                    </div><!-- /.tab content -->
                                </div><!-- /.nav -->
                            </div><!-- /.col sm  12-->
                            <div class="col-sm-12" style="display:none">
                                <div class="col-sm-3">
                                    <label class="control-label">Tipo de Ruta:</label>
                                    <select id="slct_tipo_ruta" name="slct_tipo_ruta">
                                        <option value="1">Trámite</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <a class="btn btn-default btn-sm btn-sm" id="btn_close">
                                    <i class="fa fa-remove fa-lg"></i>&nbsp;Close
                                </a>
                                <a class="btn btn-primary btn-sm" id="btn_guardar_todo">
                                    <i class="fa fa-save fa-lg"></i>&nbsp;Guardar
                                </a>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box -->
                <!-- Finaliza contenido -->
            </div>
        </div>

    </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.ruta.form.ruta' )
     @include( 'admin.ruta.form.proceso' )
     @include( 'admin.ruta.form.microproceso' )
@stop
