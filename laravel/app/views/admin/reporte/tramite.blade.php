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
    @include( 'admin.reporte.js.tramite_ajax' )
    @include( 'admin.reporte.js.tramite' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reporte de Tramite por fecha
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Reporte de Ruta por Tramite</li>
        </ol>
    </section>

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="row form-group">
                <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                </div>
                <div class="col-sm-4">
                    <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="Mostrar">
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
                                <th>Tramite</th>
                                <th>Dueño de proceso</th>
                                <th>Area</th>
                                <th>OK</th>
                                <th>Error</th>
                                <th>Depende</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Orden</th>
                                <th>Area</th>
                                <th>Tiempo</th>
                            </tr>
                        </thead>
                        <tbody id="tb_reporte">
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Tramite</th>
                                <th>Dueño de proceso</th>
                                <th>Area</th>
                                <th>OK</th>
                                <th>Error</th>
                                <th>Depende</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Orden</th>
                                <th>Area</th>
                                <th>Tiempo</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section><!-- /.content -->

@stop