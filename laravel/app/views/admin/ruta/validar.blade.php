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
    @include( 'admin.ruta.js.validar_ajax' )
    @include( 'admin.ruta.js.validar' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Gestión de los Pasos del Trámite
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Ruta</a></li>
                        <li class="active">gestión del paso</li>
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
                                                <label class="control-label">Area del Dueño del Proceso:</label>
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
                                                            <th style="width:90px !important;">Nro Trámite</th>
                                                            <th style="width:30px !important;">Paso</th>
                                                            <th style="width:350px !important;">Acciones</th>
                                                            <th style="width:90px !important;">Fecha Inicio del Paso</th>
                                                            <th style="width:90px !important;">F. Final Prog. del Paso</th>
                                                            <th>Proceso</th>
                                                            <th>Area</th>
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
                                                            <th>Acciones</th>
                                                            <th>Fecha Inicio del Paso</th>
                                                            <th>F. Final Prog. del Paso</th>
                                                            <th>Proceso</th>
                                                            <th>Area</th>
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
                                            <h1><span id="txt_titulo2">Gestionar</span>
                                            <small>
                                                <i class="fa fa-angle-double-right fa-lg"></i>
                                                <span id="texto_fecha_creacion2">:</span>
                                            </small>
                                            </h1>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-2">
                                                <label class="control-label">Nro Trámite:</label>
                                                <input type="text" class="form-control" id="txt_id_doc" readonly>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Solicitante:</label>
                                                <input type="text" class="form-control" id="txt_solicitante" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label">Fecha Trámite:</label>
                                                <input type="text" class="form-control" id="txt_fecha_tramite" readonly>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label">Sumilla:</label>
                                                <textarea type="text" class="form-control" id="txt_sumilla" readonly></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-2">
                                                <label class="control-label">Proceso:</label>
                                                <input type="text" class="form-control" id="txt_flujo" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label">Area:</label>
                                                <input type="text" class="form-control" id="txt_area" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label">Paso:</label>
                                                <input type="text" class="form-control" id="txt_orden" readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="control-label">Fecha Inicio:</label>
                                                <input type="text" class="form-control" id="txt_fecha_inicio" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-3">
                                                <label class="control-label">Tiempo asignado al paso:</label>
                                                <input type="text" class="form-control" id="txt_tiempo" readonly>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Tiempo Final:</label>
                                                <input type="text" class="form-control" id="txt_respuesta" name="txt_respuesta" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-3">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:center" rowspan="2">Nro</th>
                                                            <th style="text-align:center" rowspan="2">¿Es Condicional?</th>
                                                            <th style="text-align:center" rowspan="2">Rol que Realiza</th>
                                                            <th style="text-align:center" colspan="3">Acciones a Realizar</th>
                                                            <th style="text-align:center" colspan="2">Acciones Realizadas</th>
                                                            <th style="text-align:center" rowspan="2">[-]</th>
                                                        </tr>
                                                        <tr>
                                                            <th style="text-align:center">Verbo</th>
                                                            <th style="text-align:center">Tipo Documento</th>
                                                            <th style="text-align:center">Descripcion</th>
                                                            <th style="text-align:center">Documento Generado</th>
                                                            <th style="text-align:center">Observaciones</th>
                                                            <!--th style="text-align:center">Adjuntar Doc. Generado</th-->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="t_detalle_verbo"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-3">
                                                <label class="control-label">Tipo de respuesta del Paso:</label>
                                                <select id="slct_tipo_respuesta" name="slct_tipo_respuesta">
                                                    <option>Seleccione</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Detalle de respuesta del Paso:</label>
                                                <select id="slct_tipo_respuesta_detalle" name="slct_tipo_respuesta_detalle">
                                                    <option>Seleccione</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Descripción de respuesta del Paso:</label>
                                                <textarea class="form-control" id="txt_observacion" name="txt_observacion" rows="3"></textarea>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Estado Final del Paso(Alerta):</label>
                                                <input type="hidden" class="form-control" id="txt_alerta" name="txt_alerta">
                                                <input type="hidden" class="form-control" id="txt_alerta_tipo" name="txt_alerta_tipo">
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
                                        <div class="col-sm-12">
                                            <div class="col-sm-4">
                                                <label class="control-label">Dueño del Proceso:</label>
                                                <input class="form-control" type="text" id="txt_persona" name="txt_persona" readonly>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Proceso:</label>
                                                <select class="form-control" name="slct_flujo_id" id="slct_flujo_id">
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Area del Dueño del Proceso:</label>
                                                <select class="form-control" name="slct_area_id" id="slct_area_id">
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
                                                            <th style="width:150px !important;min-width: 200px !important;" >
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
                                            <a class="btn btn-default btn-sm btn-sm" id="btn_close2">
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
