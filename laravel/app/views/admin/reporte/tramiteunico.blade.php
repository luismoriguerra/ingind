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
    @include( 'admin.ruta.js.ruta' )
    @include( 'admin.ruta.js.expediente_ajax' )
    @include( 'admin.ruta.js.expediente' )
    
    @include( 'admin.reporte.js.tramiteunico_ajax' )
    @include( 'admin.reporte.js.tramiteunico' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Vista de Trámites
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Vista de trámites</li>
        </ol>
    </section>

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
        <!-- Custom Tabs -->
        <form id="form_tramiteunico" name="form_tramiteunico" method="post">
            <div class="col-xl-12">
                <fieldset>
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <label class="control-label">Trámite:</label>
                                <input type="text" class="form-control" placeholder="Tipo + Nro + Año  => Ej: EX {{ rand(3000,9999) }} {{ date("Y") }}" id="txt_tramite" name="txt_tramite"/>
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label"></label>
                                <input type="button" class="form-control btn btn-primary" id="generar_1" name="generar_1" value="Mostrar">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <hr>
            <div class="col-xl-12">
                <div class="form-group">
                    <table id="t_reportet_tab_1" class="table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th style="width:15%;">Tramite Asignado</th>
                                <th style="width:15%;">Tramite Bandeja</th>
                                <th style="width:25%;">Proceso</th>
                                <th style="width:25%;">Sumilla</th>
                                <th style="width:5%;">Estado</th>
                                <th style="width:10%;">Fecha Inicio</th>
                                <th style="width:5%;"> [ ] </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <hr>
            <div class="col-xl-12">
                <div class="form-group">
                    <table id="t_reported_tab_1" class="table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th colspan="6" style='background-color:#DEFAFA; width: 30% !important;'>Datos del paso</th>
                                <th style='background-color:#F5DF9D; width: 35% !important;'>Acciones a realizar</th>
                                <th style='background-color:#FCD790; width: 35% !important;'>Acciones realizadas</th>
                            </tr>
                            <tr>
                                <th style='background-color:#DEFAFA'>N°</th>
                                <th style='background-color:#DEFAFA'>Área</th>
                                <th style='background-color:#DEFAFA'>Tiempo</th>
                                <th style='background-color:#DEFAFA'>Inicio</th>
                                <th style='background-color:#DEFAFA'>Final</th>
                                <th style='background-color:#DEFAFA'>Estado final</th>

                                <th style='background-color:#F5DF9D'>Rol "tiene que"
                                Accion
                                Tipo Doc.
                                (Descripcion)
                                </th>

                                <th style='background-color:#FCD790'>Estado
                                (N° Doc.
                                Descripcion)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </section><!-- /.content -->

@stop
@section('formulario')
    @include( 'admin.ruta.form.rutaflujo' )
    @include( 'admin.ruta.form.ruta' )
    @include( 'admin.reporte.form.expediente' )
@stop
