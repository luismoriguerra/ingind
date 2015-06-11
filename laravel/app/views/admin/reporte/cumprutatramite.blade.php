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
    @include( 'admin.reporte.js.cump_ruta_tramite_ajax' )
    @include( 'admin.reporte.js.cump_ruta_tramite' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Vista de estados de los trámites por Proceso
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Vista de estados de los trámites por Proceso</li>
        </ol>
    </section>

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <fieldset>
                <div class="row form-group" id="div_fecha">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <label class="control-label">Proceso:</label>
                            <select class="form-control" name="slct_flujos" id="slct_flujos">
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label">Rango de Fechas:</label>
                            <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label"></label>
                            <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="Mostrar">
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
                                <th>Tramite</th>
                                <th>Tipo Sol.</th>
                                <th>Solicitante</th>
                                <th>Sumilla</th>
                                <th>Estado</th>
                                <th>Paso a la fecha</th>
                                <th>Total de pasos</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
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

                                <th style='background-color:#F5DF9D'>Rol</th>
                                <th style='background-color:#F5DF9D'>Accion</th>
                                <th style='background-color:#F5DF9D'>Tipo Doc.</th>
                                <th style='background-color:#F5DF9D'>Descripcion</th>

                                <th style='background-color:#FCD790'>N° Doc.</th>
                                <th style='background-color:#FCD790'>Descripcion</th>
                                <th style='background-color:#FCD790'>Estado</th>
                            </tr>
                        </thead>
                        <tbody id="tb_reporteDetalle">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section><!-- /.content -->

@stop
