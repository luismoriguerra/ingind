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
                <form id="form_reporte" name="form_reporte" action="" method="post">
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
                </form>
            </div><!-- /.box -->
            <div class="box-body table-responsive">
                <div class="row form-group" id="reporte" style="display:none;">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_reporte" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tramite</th>
                                        <th>Tiempo</th>
                                        <th>Fecha Inicio</th>
                                        <th>Orden</th>
                                        <th>Fecha tramite</th>
                                        <th>Nombre</th>
                                        <th>Respuesta</th>
                                        <th>observacion</th>
                                        <th>Tipo solicitante</th>
                                        <th>Solicitante</th>
                                        <th>Observacion</th>
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
