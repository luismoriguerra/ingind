<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}


    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.reporte.js.cump_area_ajax' )
    @include( 'admin.reporte.js.cump_area' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Reporte de Cumplimiento de ruta por tramite
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Reporte</a></li>
                        <li class="active">Reporte de Cumplimiento de ruta por tramite</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- Inicia contenido -->
                            <div class="box">
                                
                                <div class="row form-group" >
                                    <div class="col-sm-12">
                                        <div class="col-sm-3">
                                            <label class="control-label">Tipo Flujo:</label>
                                            <select class="form-control" name="slct_flujo_id" id="slct_flujo_id">
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="control-label">Area:</label>
                                            <select class="form-control" name="slct_area_id" id="slct_area_id">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group" >
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-primary" id="generar" name="generar">
                                            Mostrar
                                        </button>
                                    </div>
                                </div>
                            </div><!-- /.box -->
                                <div class="row form-group" id="reporte" style="display:none;">
                                    <div class="col-sm-12">
                                        <div class="box-body table-responsive">
                                            <table id="t_reporte" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Código de Tramite</th>
                                                        <th>Orden</th>
                                                        <th>Verbo(s)</th>
                                                        <th>Tiempo Asignado</th>
                                                        <!-- <th>Cant</th> -->
                                                        <th>Inicio</th>
                                                        <th>Final</th>
                                                        <th>Alerta</th>
                                                        <th>Tipo Alerta</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_reporte">
                                                    
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Código de Tramite</th>
                                                        <th>Orden</th>
                                                        <th>Verbo(s)</th>
                                                        <th>Tiempo Asignado</th>
                                                        <!-- <th>Cant</th> -->
                                                        <th>Inicio</th>
                                                        <th>Final</th>
                                                        <th>Alerta</th>
                                                        <th>Tipo Alerta</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <!-- <div class="row form-group">
                                    <div class="col-sm-12">
                                        <div id="chart"></div>
                                    </div>
                                </div>
                                <div class="row form-group" id="reporte_detalle" style="display:none;">
                                    <div class="col-sm-12">
                                        <div class="box-body table-responsive">
                                            <table id="t_reporteDetalle" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Area</th>
                                                        <th>Tiempo</th>
                                                        <th>Fecha</th>
                                                        <th>Cant</th>
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
                                </div> -->
                                
                            </div><!-- /.box -->
                            <!-- Finaliza contenido -->
                        </div>
                    </div>

                </section><!-- /.content -->
@stop
