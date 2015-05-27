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
                        Vista de estados de los trámites por área
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Reporte</a></li>
                        <li class="active">Vista de estados de los trámites</li> por área
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
                                        <!--div class="col-sm-4">
                                            <label class="control-label">Tipo Flujo:</label>
                                            <select class="form-control" name="slct_flujo_id" id="slct_flujo_id">
                                            </select>
                                        </div-->
                                        <div class="col-sm-4">
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
                                                        <th>Nombre del proceso</th>
                                                        <th>Dueño del Proceso</th>
                                                        <th>Área del dueño</th>
                                                        <th>N° de Áreas de la ruta</th>
                                                        <th>N° de Pasos de la ruta</th>
                                                        <th>Tiempo total de la ruta</th>
                                                        <th>Detalle</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_reporte">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="row form-group" id="reporte_detalle" style="display:none;">
                                    <div class="col-sm-12">
                                        <div class="box-body table-responsive">
                                            <table id="t_reporteDetalle" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Tramite</th>
                                                        <th>Tipo Sol.</th>
                                                        <th>Solicitante</th>
                                                        <th>Sumilla</th>
                                                        <th>Estado</th>
                                                        <th>N° paso</th>
                                                        <th>área</th>
                                                        <th>Fecha Inicio</th>
                                                        <th>Fecha Fin</th>
                                                        <th>Detalle</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_reporteDetalle">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group" id="reporte_detalle2" style="display:none;">
                                    <div class="col-sm-12">
                                        <div class="box-body table-responsive">
                                            <table id="t_reporteDetalle2" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Paso</th>
                                                        <th>Área</th>
                                                        <th>Tiempo</th>
                                                        <th>Inicio</th>
                                                        <th>Final</th>
                                                        <th>Tiempo final</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_reporteDetalle2">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div><!-- /.box -->
                            <!-- Finaliza contenido -->
                        </div>
                    </div>

                </section><!-- /.content -->
@stop
