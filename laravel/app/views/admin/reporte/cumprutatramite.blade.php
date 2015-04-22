<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('http://cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    
    {{ HTML::style('lib/morris/morris-0.4.3.min.css') }}
    {{ HTML::script('lib/morris/raphael-min.js') }}
    {{ HTML::script('lib/morris/morris-0.4.3.min.js') }}
    
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
            Reporte de Cumplimiento por Ruta
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Reporte de Cumplimiento por Ruta</li>
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
                            <label class="control-label">Tipo Flujo:</label>
                            <select class="form-control" name="slct_flujos" id="slct_flujos">
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="control-label">Rango de Fechas:</label>
                            <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                        </div>
                        
                    </div>
                </div>
            </fieldset>

            <div class="row form-group">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary" id="generar" name="generar">
                        Mostrar
                    </button>
                </div>
            </div>
        </div>
        <div class="box-body table-responsive">
            <div class="row form-group" id="reporte" style="display:none;">
                <div class="col-sm-12">
                    <table id="t_reporte" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>software</th>
                                <th>Persona</th>
                                <th>Area</th>
                                <th>Fecha Inicio</th>
                                <th>Sin Alerta</th>
                                <th>Alerta</th>
                                <th>Alerta Validada</th>
                                <th> [ ] </th>
                            </tr>
                        </thead>
                        <tbody id="tb_reporte">
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>software</th>
                                <th>Persona</th>
                                <th>Area</th>
                                <th>Fecha Inicio</th>
                                <th>Sin Alerta</th>
                                <th>Alerta</th>
                                <th>Alerta Validada</th>
                                <th> [ ] </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
<!--         <div class="row form-group">
    <div class="col-sm-12">
        <div id="chart"></div>
    </div>
</div> -->
        <div class="box-body table-responsive" >
            <div class="row form-group" id="reporte_detalle" style="display:none;">
                <div class="col-sm-12">
                    <table id="t_reporteDetalle" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Area</th>
                                <th>Tiempo Asignado</th>
                                <th>Fecha</th>
                                <!-- <th>Cant</th> -->
                                <th>Tiempo final</th>
                                <th># orden</th>
                                <th>Alerta</th>
                                <th>Accion</th>
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