<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    
    {{ HTML::style('lib/morris/morris-0.4.3.min.css') }}
    {{ HTML::script('lib/morris/raphael-min.js') }}
    {{ HTML::script('lib/morris/morris-0.4.3.min.js') }}
    
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.reporte.js.ruta_tramite_ajax' )
    @include( 'admin.reporte.js.ruta_tramite' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reporte de Ruta por Tramite
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
        <form name="form_movimiento" id="form_movimiento" method="post" action="reporte/movimiento" enctype="multipart/form-data">
            <fieldset>
                <div class="row form-group" id="div_fecha">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <select class="form-control" name="slct_flujos" id="slct_flujos">
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                        </div>
                        
                    </div>
                </div>
            </fieldset>
            
        </form>
        <div class="row form-group">
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary" id="generar_movimientos" name="generar_movimientos">
                    Mostrar
                </button>
            </div>
        </div>

        <div class="box-body table-responsive">
            <table id="t_reporte" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>software</th>
                        <th>Persona</th>
                        <th>Area</th>
                        <th>Fecha Inicio</th>
                        <th>Ok</th>
                        <th>Error</th>
                        <th>Corregido</th>
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
                        <th>Ok</th>
                        <th>Error</th>
                        <th>Corregido</th>
                        <th> [ ] </th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <div id="chart"></div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-12">
                <ul class="list-group" id="t_reporteDetalle"></ul>
            </div>
        </div>
    </section><!-- /.content -->

@stop