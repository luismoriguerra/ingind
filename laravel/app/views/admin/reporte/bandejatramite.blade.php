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
    @include( 'admin.reporte.js.bandejatramite_ajax' )
    @include( 'admin.reporte.js.bandejatramite' )
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
            <li class="active">Vista de estados de los trámites por área</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <div class="box">
                <fieldset>
                    <div class="row form-group" >
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <label class="control-label">Tipo:</label>
                                <select class="form-control" name="slct_tipo_visualizacion" id="slct_tipo_visualizacion" multiple>
                                </select>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div><!-- /.box -->
            <div class="box-body table-responsive">
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
                                        <th>Fecha Creación</th>
                                        <th>Fecha Producción</th>
                                        <th>N° Tramites</th>
                                        <th>Nombre del proceso</th>
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
                    </div>
                </div>
                
            </div><!-- /.box -->
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
@stop
