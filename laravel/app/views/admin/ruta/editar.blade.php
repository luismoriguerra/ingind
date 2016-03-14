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
    @include( 'admin.ruta.js.editar_ajax' )
    @include( 'admin.ruta.js.editar' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Editar Trámites Trabados
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Ruta</a></li>
                        <li class="active">Editar</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- Inicia contenido -->
                            <div class="box">
                                <form name="form_validar" id="form_validar" method="POST" action="">
                                    <div class="row form-group" >
                                        <div class="col-sm-12">
                                            <!--div class="col-sm-3">
                                                <label class="control-label">Proceso:</label>
                                                <select class="form-control" name="slct_flujo2_id" id="slct_flujo2_id">
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Area:</label>
                                                <select class="form-control" disabled name="slct_area2_id" id="slct_area2_id">
                                                </select>
                                            </div-->
                                            <div class="col-sm-3">
                                                <label class="control-label">Ingrese Nro Trámite:</label>
                                                <input type="text" id="txt_tramite" name="txt_tramite">
                                                <a class="btn btn-warning btn-sm" id="btn_buscar">
                                                    <i class="fa fa-search fa-lg"></i>&nbsp;
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group" id="tabla_ruta_detalle" style="display:none;">
                                        <div class="col-sm-12">
                                            <div class="box-body table-responsive">
                                                <table id="t_ruta_detalle" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nro Trámite</th>
                                                            <th>Paso</th>
                                                            <th>Tiempo Asig. del Paso </th>
                                                            <th>Fecha Inicio del Paso</th>
                                                            <th>Fecha Final del Paso</th>
                                                            <th>Descripción de respuesta del Paso</th>
                                                            <th>Estado Final del Paso</th>
                                                            <th> [ ] </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb_ruta_detalle">
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Nro Trámite</th>
                                                            <th>Paso</th>
                                                            <th>Tiempo Asig. del Paso </th>
                                                            <th>Fecha Inicio del Paso</th>
                                                            <th>Fecha Final del Paso</th>
                                                            <th>Descripción de respuesta del Paso</th>
                                                            <th>Estado Final del Paso</th>
                                                            <th> [ ] </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <form name="form_ruta_flujo" id="form_ruta_flujo" method="POST" action="">
                                    <div class="row form-group" style="display:none">
                                        <div class="col-sm-12">
                                            <h1><span id="txt_titulo">Nueva Ruta</span>
                                            <small>
                                                <i class="fa fa-angle-double-right fa-lg"></i>
                                                <span id="texto_fecha_creacion">Fecha Creación:</span>
                                                <span id="fecha_creacion"></span>
                                            </small>
                                            </h1>
                                        </div>
                                        <input type="hidden" id="txt_ruta_id" name="txt_ruta_id">
                                        <input type="hidden" id="txt_ruta_detalle_id" name="txt_ruta_detalle_id">
                                        <input type="hidden" id="txt_orden_max" name="txt_orden_max">
                                        <input type="hidden" id="condicional" name="condicional" value="0">
                                        <div class="col-sm-12">
                                            <div class="col-sm-4">
                                                <label class="control-label">Dueño del Proceso:</label>
                                                <input class="form-control" type="text" id="txt_persona" name="txt_persona" readonly>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Proceso:</label>
                                                <select class="form-control" name="slct_flujo_id" id="slct_flujo_id" disabled>
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
                                            <div class="col-sm-2">
                                                <label>Iniciará en el paso:</label>
                                                <input type="number" id="txt_iniciara" name="txt_iniciara" class="form-control">
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Estado Final:</label>
                                                <select id="slct_estado_final" name="slct_estado_final">
                                                    <option value="">Seleccione</option>
                                                    <option value="2">Validado</option>
                                                    <option value="3">Denegado</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Desea ud que esta nueva ruta modificada permanesca para los tramites futuros?</label>
                                                <select id="slct_crear_nuevo" name="slct_crear_nuevo">
                                                    <option value="">Seleccione</option>
                                                    <option value="1">Si Deseo</option>
                                                    <option value="0">No Deseo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <a class="btn btn-default btn-sm btn-sm" id="btn_close2">
                                                <i class="fa fa-remove fa-lg"></i>&nbsp;Close
                                            </a>
                                            <a class="btn btn-primary btn-sm" id="btn_guardar_todo">
                                                <i class="fa fa-save fa-lg"></i>&nbsp;Guardar
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
