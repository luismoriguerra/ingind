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
                                <input type="text" class="form-control" placeholder="Tipo + Nro + Año  => Ej: EX {{ rand(3000,9999) }} {{ date("Y") }}" id="txt_tramite_1" name="txt_tramite_1"/>
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
                                <th>Tramite</th>
                                <th>Sumilla</th>
                                <th>Estado</th>
                                <th>Paso a la fecha</th>
                                <th>Total de pasos</th>
                                <th>Fecha Inicio</th>
                                <th> [ ] </th>
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

        <form name="form_ruta_flujo" id="form_ruta_flujo" style="display:none" method="POST" action="">
            <div class="row form-group">
                <div class="col-sm-12">
                    <h1><span id="txt_titulo">Nueva Ruta</span>
                    <small>
                        <i class="fa fa-angle-double-right fa-lg"></i>
                        <span id="texto_fecha_creacion">Fecha Creación:</span>
                        <span id="fecha_creacion"></span>
                    </small>
                    </h1>
                </div>
                <div class="col-sm-12">
                    <div class="col-sm-4">
                        <label class="control-label">Dueño del Proceso:</label>
                        <input class="form-control" type="text" id="txt_persona" name="txt_persona" readonly>
                    </div>
                    <div class="col-sm-4">
                        <label class="control-label">Proceso:</label>
                        <input class="form-control" type="text" id="txt_proceso" name="txt_proceso" readonly>
                    </div>
                    <div class="col-sm-4">
                        <label class="control-label">Area del Dueño del Proceso:</label>
                        <input class="form-control" type="text" id="txt_area" name="txt_area" readonly>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-12">
                    <div class="box-body">
                        <table id="areasasignacion" class="table table-bordered" style="min-height:300px">
                            <thead> 
                                <tr class="head">
                                    <th style="width:250px !important;min-width: 200px !important;" >
                                    </th>
                                    <th class="eliminadetalleg" style="min-width:1000px important!;">[]</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="body">
                                    <td>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr><th colspan="2">
                                                </th></tr>
                                                <tr class="head">
                                                    <th>#</th>
                                                    <th>Area</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tb_rutaflujodetalleAreas">
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="head">
                                    <th>#</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12">
                    <a class="btn btn-default btn-sm btn-sm" id="btn_close">
                        <i class="fa fa-remove fa-lg"></i>&nbsp;Close
                    </a>
                </div>
            </div>
        </form>
    </section><!-- /.content -->

@stop
@section('formulario')
     @include( 'admin.ruta.form.ruta' )
@stop
