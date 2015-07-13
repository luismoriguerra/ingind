<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    
    {{ HTML::script('lib/input-mask/js/jquery.inputmask.js') }}
    {{ HTML::script('lib/input-mask/js/jquery.inputmask.date.extensions.js') }}
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.ruta.js.ruta_ajax' )
    @include( 'admin.ruta.js.estado' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Actualizar Estado Ruta del Proceso
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Ruta</a></li>
                        <li class="active">Estado</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- Inicia contenido -->
                            <div class="box">                                
                                <div class="box-body table-responsive">
                                    <table id="t_rutaflujo" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th style="width:250px !important;">Proceso</th>
                                                <th style="width:250px !important;">Area</th>
                                                <th style="width:200px !important;">Fecha Creación</th>
                                                <th>Estado</th>
                                                <th> [ ] </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tb_rutaflujo">
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>N°</th>
                                                <th>Proceso</th>
                                                <th>Area</th>
                                                <th>Fecha Creación</th>
                                                <th>Estado</th>
                                                <th> [ ] </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                                <form name="form_ruta_flujo" id="form_ruta_flujo" method="POST" action="">
                                    <div class="row form-group" style="display:none">
                                        <div class="col-sm-12">
                                            <h1><span id="txt_titulo">Nueva Ruta del Proceso</span>
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
                                            <div class="col-sm-5">
                                                <label class="control-label">Proceso:</label>
                                                <select class="form-control" name="slct_flujo_id" id="slct_flujo_id">
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Area del Dueño del Proceso:</label>
                                                <select class="form-control" name="slct_area_id" id="slct_area_id" disabled>
                                                </select>
                                            </div>
                                            <!--div class="col-sm-2">
                                                <label class="control-label"># Ok:</label>
                                                <input class="form-control" type="text" id="txt_ok" name="txt_ok" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label"># Error:</label>
                                                <input class="form-control" type="text" id="txt_error" name="txt_error" readonly>
                                            </div-->
                                        </div>                                        
                                    </div>
                                    <div class="row form-group" style="display:none">
                                        <div class="col-sm-12">
                                            <div class="box-body table-responsive">
                                                <table id="areasasignacion" class="table table-bordered" style="min-height:300px">
                                                    <thead> 
                                                        <tr class="head">
                                                            <th style="width:450px !important;min-width: 200px !important;" > 
                                                                <a id="btn_adicionar_ruta_detalle" class="btn btn-primary btn-sm">
                                                                    <i class="fa fa-plus-square fa-lg"></i>
                                                                </a>
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
                                                                            <select class="form-control" name="slct_area_id_2" id="slct_area_id_2">
                                                                            </select>
                                                                        </th></tr>
                                                                        <tr class="head">
                                                                            <th style="width:110px;">#</th>
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
     @include( 'admin.ruta.form.ruta' )
@stop
