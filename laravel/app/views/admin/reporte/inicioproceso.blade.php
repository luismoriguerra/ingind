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
    @include( 'admin.ruta.js.ruta_ajax' )
    @include( 'admin.reporte.js.cump_ruta_tramite_ajax' )
    @include( 'admin.reporte.js.inicioproceso' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reporte Cartas de inicio por proceso
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Reporte Cartas de inicio por proceso</li>
        </ol>
    </section>

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <fieldset>
                <div class="row form-group" id="div_fecha">
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <label class="control-label">Proceso:</label>
                            <select class="form-control" name="slct_flujos" id="slct_flujos" multiple>
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
                    <div class="col-sm-12">
                        <div class="col-sm-3">
                            <label class="control-label">Tipo Fecha:</label>
                            <select class="form-control" name="slct_tipo_fecha" id="slct_tipo_fecha" >
                            <option value="1">Producción del proceso</option>
                            <option value="2">Ingreso del tramite al proceso</option>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="box-body table-responsive">
            <div class="row form-group" id="reporte_t" style="display:none;">
                <div class="col-sm-12">
                    <div class="box-body table-responsive">
                        <table id="t_reporte_t" class="table table-bordered">
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
                                    <th>Inconclusos</th>
                                    <th>Conclusos</th>
                                    <th> [ ] </th>
                                </tr>
                            </thead>
                            <tbody id="tb_reporte_t">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
            <div class="row form-group" id="reporte" style="display:none;">
                <div class="col-sm-12">
                    <table id="t_reporte" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Carta Inicio</th>
                                <th>Autoriza / Responsable</th>
                                <th>Objetivo</th>
                                <th>Estado</th>
                                <th>Paso a la fecha</th>
                                <th>Total de pasos</th>
                                <th>Fecha Trámite</th>
                                <th>Fecha Inicio</th>
                                <th>Pasos Sin alertas</th>
                                <th>Pasos Con alertas</th>
                                <th>Pasos Alertas validadas</th>
                                <th> [ ] </th>
                            </tr>
                        </thead>
                        <tbody id="tb_reporte">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="box-body table-responsive" >
            <div class="row form-group" id="reporte_detalle" style="display:none;">
                <div class="col-sm-12">
                    <table id="t_reporteDetalle" class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="6" style='background-color:#DEFAFA'>Datos del paso</th>
                                <th colspan="4" style='background-color:#F5DF9D'>Acciones a realizar</th>
                                <th colspan="3" style='background-color:#FCD790'>Acciones realizadas</th>
                            </tr>
                            <tr>
                                <th style='background-color:#DEFAFA'>Paso</th>
                                <th style='background-color:#DEFAFA'>Área</th>
                                <th style='background-color:#DEFAFA'>Tiempo</th>
                                <th style='background-color:#DEFAFA'>Inicio</th>
                                <th style='background-color:#DEFAFA'>Final</th>
                                <th style='background-color:#DEFAFA'>Estado final</th>

                                <th colspan="4" style='background-color:#F5DF9D'>Rol "tiene que"
                                Accion
                                Tipo Doc.
                                (Descripcion)
                                </th>

                                <th colspan="3" style='background-color:#FCD790'>Estado
                                (N° Doc.
                                Descripcion)
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tb_reporteDetalle">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <form name="form_ruta_flujo" id="form_ruta_flujo" method="POST" action="">
            <div class="row form-group" style="display:none">
                <div class="col-sm-12">
                    <h1><span id="txt_titulo">Nueva Ruta</span>
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
                    <div class="col-sm-3">
                        <label class="control-label">Proceso:</label>
                        <select class="form-control" name="slct_flujo_id" id="slct_flujo_id">
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label class="control-label">Area del Dueño del Proceso:</label>
                        <select class="form-control" name="slct_area_id" id="slct_area_id">
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
                    <div class="box-body table-responsive">
                        <table id="areasasignacion" class="table table-bordered" style="min-height:300px">
                            <thead>
                                <tr class="head">
                                    <th style="width:250px !important;min-width: 200px !important;" >
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
                                                    <th>#</th>
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
                    </div>
                </div>
                <div class="col-sm-12">
                    <a class="btn btn-default btn-sm btn-sm" id="btn_close">
                        <i class="fa fa-remove fa-lg"></i>&nbsp;Close
                    </a>
                </div>
            </div>
        </form>
    </section><!-- /.content -->

@stop
@section('formulario')
     @include( 'admin.ruta.form.ruta' )
@stop
