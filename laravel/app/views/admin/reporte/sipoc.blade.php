<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::style('lib/datetime/css/bootstrap-datetimepicker.min.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    
    {{ HTML::script('lib/datetime/js/bootstrap-datetimepicker.min.js') }}
    {{ HTML::script('lib/printthis/printThis.js') }}
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.ruta.js.ruta_ajax' )
    @include( 'admin.ruta.js.asignar_ajax' )
    @include( 'admin.reporte.js.sipoc' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Reporte SIPOC y Flujo de Proceso
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Reporte</a></li>
                        <li class="active">SIPOC y Flujo de Proceso</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- Inicia contenido -->
                            <div class="box">
                                <form name="form_asignar" id="form_asignar" method="POST" action="">
                                    <div class="row form-group" >
                                        <div class="col-sm-12">
                                            <div class="col-sm-5">
                                                <label class="control-label">Proceso:</label>
                                                <select class="form-control" name="slct_flujo2_id" id="slct_flujo2_id">
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Area:</label>
                                                <select class="form-control" disabled name="slct_area2_id" id="slct_area2_id">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group" id="tabla_ruta_flujo" style="display:none;">
                                        <div class="col-sm-12">
                                            <div class="box-body table-responsive">
                                                <table id="t_ruta_flujo" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Proceso</th>
                                                            <th>Area</th>
                                                            <th>Dueño del Proceso</th>
                                                            <th>Nro Trámite Ok</th>
                                                            <th>Nro Trámite Error</th>
                                                            <th>Fecha Creación</th>
                                                            <th> [ ] </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb_ruta_flujo">
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Proceso</th>
                                                            <th>Area</th>
                                                            <th>Dueño del Proceso</th>
                                                            <th>Nro Trámite Ok</th>
                                                            <th>Nro Trámite Error</th>
                                                            <th>Fecha Creación</th>
                                                            <th> [ ] </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <form name="form_ruta_flujo" id="form_ruta_flujo" method="POST" action="">
                                    <div class="col-sm-12">
                                        <div class="col-sm-3">
                                            <a class='btn btn-primary btn-sm' href='reporte/sipoc' >PDF</i></a>
                                        </div>
                                    </div>
                                    <div class="row form-group" >
                                        <div class="col-sm-12">
                                            <div class="box-body table-responsive">
                                                <table class="table table-bordered table-hover table-striped">
                                                    <thead>
                                                    <tr style="background-color:#4F6228; color:#FFFFFF;">
                                                        <th style="text-align:center;" colspan="6">SIPOC</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="background-color:#DEFAFA; text-align:center;">PASO</th>
                                                        <th style="background-color:#DEFAFA; text-align:center;">PROVEEDOR</th>
                                                        <th style="background-color:#DEFAFA; text-align:center;">ENTRADA</th>
                                                        <th style="background-color:#F5DF9D; text-align:center;">PROCESO</th>
                                                        <th style="background-color:#DEFAFA; text-align:center;">SALIDA</th>
                                                        <th style="background-color:#DEFAFA; text-align:center;">CLIENTE</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tdetalle">
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
                                    <div class="row form-group" style="display:none">
                                        <div class="col-sm-12">
                                            <h1 class="col-sm-3"><span id="txt_titulo">Nueva Ruta</span>
                                            <small>
                                                <i class="fa fa-angle-double-right fa-lg"></i>
                                                <span id="texto_fecha_creacion">Fecha Creación:</span>
                                                <span id="fecha_creacion"></span>
                                            </small>
                                            </h1>
                                            <div class="col-sm-3">
                                                <a class="btn btn-default btn-sm btn-sm" id="btn_imprimir">
                                                    <i class="fa fa-print fa-lg"></i>&nbsp;Imprimir
                                                </a>
                                            </div>
                                            <div class="col-sm-3">
                                                <a class="btn btn-default btn-sm btn-sm" onclick="window.print();">
                                                    <i class="fa fa-print fa-lg"></i>&nbsp;Imprimir
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-4">
                                                <label class="control-label">Dueño del Proceso:</label>
                                                <input class="form-control" type="text" id="txt_persona" name="txt_persona" readonly>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Proceso:</label>
                                                <select class="form-control" name="slct_flujo_id" id="slct_flujo_id">
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Area del Dueño del Proceso:</label>
                                                <select class="form-control" name="slct_area_id" id="slct_area_id">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group" style="display:none">
                                        <div class="col-sm-12">
                                            <div class="box-body table-responsive">
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
                            </div><!-- /.box -->
                            <!-- Finaliza contenido -->
                        </div>
                    </div>

                </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.ruta.form.asignar' )
     @include( 'admin.ruta.form.ruta' )
@stop
