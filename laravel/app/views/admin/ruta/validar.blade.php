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

    @include( 'admin.ruta.js.validar_ajax' )
    @include( 'admin.ruta.js.validar' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Validar Ruta
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Ruta</a></li>
                        <li class="active">Validar</li>
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
                                            <div class="col-sm-3">
                                                <label class="control-label">Tipo Flujo:</label>
                                                <select class="form-control" name="slct_flujo_id" id="slct_flujo_id" onchange="mostrarRutaFlujo();">
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Area:</label>
                                                <select class="form-control" name="slct_area_id" id="slct_area_id" onchange="mostrarRutaFlujo();">
                                                </select>
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
                                                            <th>Tipo Flujo</th>
                                                            <th>Area</th>
                                                            <th>Software</th>
                                                            <th>ID Doc</th>
                                                            <th>Orden</th>
                                                            <th>Fecha Inicio</th>
                                                            <th>Verbo(s)</th>
                                                            <th> [ ] </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb_ruta_detalle">
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Tipo Flujo</th>
                                                            <th>Area</th>
                                                            <th>Software</th>
                                                            <th>ID Doc</th>
                                                            <th>Orden</th>
                                                            <th>Fecha Inicio</th>
                                                            <th>Verbo(s)</th>
                                                            <th> [ ] </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <form name="form_ruta_detalle" id="form_ruta_detalle" method="POST" action="">
                                    <div class="row form-group" style="display:none">
                                        <div class="col-sm-12">
                                            <h1><span id="txt_titulo">Validación</span>
                                            <small>
                                                <i class="fa fa-angle-double-right fa-lg"></i>
                                                <span id="texto_fecha_creacion">:</span>
                                            </small>
                                            </h1>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-2">
                                                <label class="control-label">Tipo Flujo:</label>
                                                <input type="text" class="form-control" id="txt_flujo" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label">Area:</label>
                                                <input type="text" class="form-control" id="txt_area" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label">Software:</label>
                                                <input type="text" class="form-control" id="txt_software" readonly>
                                            </div>                                            
                                            <div class="col-sm-2">
                                                <label class="control-label">Id Doc:</label>
                                                <input type="text" class="form-control" id="txt_id_doc" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label">Orden:</label>
                                                <input type="text" class="form-control" id="txt_orden" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label">Fecha Inicio:</label>
                                                <input type="text" class="form-control" id="txt_fecha_inicio" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-3">
                                                <label class="control-label">Tiempo:</label>
                                                <input type="text" class="form-control" id="txt_tiempo" readonly>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Respuesta:</label>
                                                <input type="text" class="form-control" id="txt_respuesta" readonly>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Tipo Respuesta:</label>
                                                <select id="slct_tipo_respuesta" name="slct_tipo_respuesta">
                                                    <option>Seleccione</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Detalle Respuesta:</label>
                                                <select id="slct_tipo_respuesta_detalle" name="slct_tipo_respuesta_detalle">
                                                    <option>Seleccione</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-3">
                                                <table>
                                                    <thead><tr><th>Verbo</th><th>[-]</th></tr></thead>
                                                    <tbody id="t_detalle_verbo"></tbody>
                                                </table>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Observación:</label>
                                                <textarea class="form-control" id="txt_observacion" name="txt_observacion" rows="3"></textarea>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Alerta:</label>
                                                <input type="hidden" class="form-control" id="txt_alerta" name="txt_alerta">
                                                <div class="progress progress-striped active">
                                                    <div id="div_cumple" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                        <span>Cumple</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <a class="btn btn-default btn-sm btn-sm" id="btn_close">
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
