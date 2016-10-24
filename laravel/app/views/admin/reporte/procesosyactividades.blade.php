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
    @include( 'admin.reporte.js.procesosyactividades_ajax' )
    @include( 'admin.reporte.js.procesosyactividades' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            LISTADO DE PROCESOS Y SUS ACTIVIDADES
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Cant. Documentos Generados por área</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <div class="box">
                <fieldset>
                    <div class="row form-group" >
                        <div class="col-sm-12">
                            <div class="col-md-4 col-sm-4">
                                <label class="control-label">Area de Actividad:</label>
                                <select class="form-control" name="slct_area_id" id="slct_area_id" multiple>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <label class="control-label">Estado Proceso:</label>
                                <select class="form-control" name="slct_estado" id="slct_estado" multiple>
                                    <option value="1">Producción</option>
                                    <option value="2">Pendiente</option>
                                </select>
                            </div>
                            <div class="col-md-1 col-sm-2" style="padding:24px">
                                <span class="btn btn-primary btn-md" id="generar" name="generar"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                            </div>
                            <div class="col-md-1 col-sm-2" style="padding:24px">
                                <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
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
                                        <th>N°</th>
                                        <th>Proceso</th>
                                        <th>Dueño(a) Proceso</th>
                                        <th>Area Creación Proceso</th>
                                        <th>Estado Proceso</th>
                                        <th>Fecha Creación</th>
                                        <th>Paso</th>
                                        <th>Area de Actividad</th>
                                        <th>Tiempo</th>
                                        <th>Usuario Modificación</th>
                                        <th>Hora Modificación</th>
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
