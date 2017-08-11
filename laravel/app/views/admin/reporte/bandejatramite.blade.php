<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    {{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }} 
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.ruta.js.ruta_ajax' )
    @include( 'admin.ruta.js.validar_ajax' )
    @include( 'admin.reporte.js.bandejatramite_ajax' )
    @include( 'admin.reporte.js.bandejatramite' )

@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Bandeja de Inconclusos y Gestión
        <small> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="#">Reporte</a></li>
        <li class="active">Bandeja de Inconclusos y Gestión</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
        <!-- Inicia contenido -->
    <div class="mailbox row">
    <div class="col-md-12">

    <div class="row form-group" id="reporte" >
        <div class="col-sm-12">
            <div class="box-body table-responsive">
            <!-- THE MESSAGES -->
            <form name="form_filtros" id="form_filtros" method="POST" action="">
                <table id="t_reporte_ajax" class="table table-mailbox">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th id="th_dg" style='width:250px !important;' class="unread">
                            Documento generado por <br>el paso anterior<br>
                            <input style='width:250px' name="txt_id_ant" id="txt_id_ant" onBlur="MostrarAjax();" onKeyPress="return enterGlobal(event,'th_dg',1)" onkeyup="Limpiar('txt_id_union,#txt_solicitante,#txt_proceso');" type="text" placeholder="" />
                            </th>
                            <th id="th_pd" style='width:250px !important;' class="unread">
                            Primer docucmento ingresado<br>
                            <input style='width:250px' name="txt_id_union" id="txt_id_union" onBlur="MostrarAjax();" onKeyPress="return enterGlobal(event,'th_pd',1)" onkeyup="Limpiar('txt_id_ant,#txt_solicitante,#txt_proceso');" type="text" placeholder="" />
                            </th>
                            <th>Tiempo</th>
                            <th id="th_fi" style='width:250px !important;' class="unread">
                            Fecha Inicio<br>
                            <input style='width:250px' name="txt_fecha_inicio_b" id="txt_fecha_inicio_b" onChange="MostrarAjax();" type="text" />
                            </th>
                            <th id="th_ep" style='width:250px !important;' class="unread">
                            Estado de la Actividadd<br>
                            <select name="slct_tiempo_final" id="slct_tiempo_final" onChange="MostrarAjax();" />
                            <option value="">.::Todo::.</option>
                            <option value="1">Dentro del Tiempo</option>
                            <option value="0">Fuera del Tiempo</option>
                            </select>
                            </th>
                            <th>Paso</th>
                            <th id="th_pr" style='width:250px !important;' class="unread">
                            Proceso<br>
                            <input style='width:250px' name="txt_proceso" id="txt_proceso" onBlur="MostrarAjax();" onKeyPress="return enterGlobal(event,'th_pr',1)" onkeyup="Limpiar('txt_id_ant,#txt_id_union,#txt_solicitante');" type="text" placeholder="" />
                            </th>
                            <th id="th_so" style='width:250px !important;' class="unread">
                            Solicitante<br>
                            <input style='width:250px' name="txt_solicitante" id="txt_solicitante" onBlur="MostrarAjax();" onKeyPress="return enterGlobal(event,'th_so',1)" onkeyup="Limpiar('txt_id_ant,#txt_id_union,#txt_proceso');" type="text" placeholder="" />
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Doc. Generado por <br>el paso anterior</th>
                            <th>Primer Documento ingresado</th>
                            <th>Tiempo</th>
                            <th>Fecha Inicio</th>
                            <th>Estado de la Actividadd</th>
                            <th>Paso</th>
                            <th>Proceso</th>
                            <th>Solicitante</th>
                        </tr>
                    </tfoot>
                </table>
            </form>
            </div><!-- /.table-responsive -->
        </div>
    </div>

    <form name="form_ruta_detalle" id="form_ruta_detalle" method="POST" action="">
        <div id="bandeja_detalle" class="row form-group" style="display:none">
            <div class="col-sm-12">
                <h1><span id="txt_titulo2">Gestionar</span>
                <small>
                    <i class="fa fa-angle-double-right fa-lg"></i>
                    <span id="texto_fecha_creacion2">:</span>
                </small>
                <a class="btn btn-sm btn-warning" id="VisualizarR" onclick="mostrarRuta(this)">
                    <i class="glyphicon glyphicon-search"></i>
                    Visualizar Ruta
                </a>
                <a class="btn btn-sm btn-primary" id="ExpedienteU">
                    <i class="fa fa-search fa-lg"></i>
                    .::Expediente::.
                </a>
                <a class="btn btn-sm btn-primary" id="RetornarP" onclick="retornar()">
                    <i class="glyphicon glyphicon-repeat"></i>
                    Retornar Paso
                </a>
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
                <div class="col-sm-4">
                    <label class="control-label">Sumilla:</label>
                    <textarea type="text" class="form-control" id="txt_sumilla" readonly></textarea>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="col-sm-4">
                    <label class="control-label">Proceso:</label>
                    <input type="text" class="form-control" id="txt_flujo" readonly>
                </div>
                <div class="col-sm-4">
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
                    <label class="control-label">Tiempo asignado a la Actividad:</label>
                    <input type="text" class="form-control" id="txt_tiempo" readonly>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">Tiempo Final:</label>
                    <input type="text" class="form-control" id="txt_respuesta" name="txt_respuesta" readonly>
                </div>
                <div class="col-sm-4">
                    <label class="control-label">Responsable de la Actividad:</label>
                    <?php
                        if( Auth::user()->rol_id==8 OR Auth::user()->rol_id==9 ){
                    ?>
                            <select id="slct_persona" data-id="0" onChange="ActualizarResponsable(this.value)"></select>
                    <?php
                        }
                        else{
                    ?>
                            <div><input class="form-control" id="slct_persona" readonly=""></div>
                    <?php
                        }
                    ?>
                    
                </div>
            </div>
            <br>
            <div class="col-sm-12" style="margin-top:20px;margin-bottom: 20px">
                <div class="table-responsive">
                <table class="table table-bordered" id="tbldetalleverbo">
                    <thead>
                        <tr>
                            <th style="text-align:center" rowspan="2">Nro</th>
                            <th style="text-align:center;width:60px !important;" rowspan="2">¿cond- icional?</th>
                            <th style="text-align:center" rowspan="2">Rol que Realiza</th>
                            <th style="text-align:center" colspan="3">Acciones a Realizar</th>
                            <th style="text-align:center" colspan="2">Acciones Realizadas</th>
                            <th style="text-align:center;width:150px !important;" rowspan="2">Persona</th>
                            <th style="text-align:center" rowspan="2">Fecha</th>
                            <th style="text-align:center" rowspan="2">[-]</th>
                        </tr>
                        <tr>
                            <th style="text-align:center">Verbo</th>
                            <th style="text-align:center">Tipo Documento</th>
                            <th style="text-align:center;width:250px !important;">Descripcion</th>
                            <th style="text-align:center; width: 250px;">Documento Generado</th>
                            <th style="text-align:center">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody id="t_detalle_verbo">
                    </tbody>
                    <tfoot>
                         <tr class="trNuevo hidden">
                            <td id="tdNro" style="vertical-align : middle;">0</td>
                            <td id="tdCondicional" style="vertical-align : middle;">NO</td>
                            <td id="tdRol" style="vertical-align : middle;">
                                <select class="form-control cboRoles" id="cboRoles" name="cboRoles"></select>
                            </td>
                            <td id="tdVerbo" style="vertical-align : middle;">
                                Generar
                                {{-- <input type="text" name="txtverbo" id="txtverbo" class="form-control" placeholder=""> --}}
                            </td>
                            <td id="tdTipoDoc" style="vertical-align : middle;">
                                {{-- <input type="text" name="txttipoDoc" id="txttipoDoc" class="form-control" placeholder=""> --}}
                                <select class="form-control cbotipoDoc" id="cbotipoDoc" name="cbotipoDoc"></select>
                            </td>
                            <td id="tdDescripcion" style="vertical-align : middle;">
                                <input type="text" name="txtdescripcion" id="txtdescripcion" class="form-control txtdescripcion" placeholder="">
                            </td>
                            <td id="tdDocumento" style="vertical-align : middle;">
                                <input type="text" name="txtdocumento" id="txtdocumento" class="form-control txtdocumento" placeholder="" disabled>
                            </td>
                            <td id="tdObservaciones" style="vertical-align : middle;">
                                <textarea class="form-control" id="txtobservacion" name="txtobservacion" disabled></textarea>
                                {{-- <input type="text" name="txtobservacion" id="txtobservacion" class="form-control" placeholder=""> --}}
                            </td>
                            <td id="tdPersona" style="vertical-align : middle;" disabled>
                                <select class="form-control" id="cboPersona" name="cboPersona" disabled></select>
                            </td>
                            <td id="tdFecha" style="vertical-align : middle;" disabled>
                              {{--   <input type="text" name="txtfecha" id="txtfecha" class="form-control" placeholder=""> --}}
                            </td>
                            <td id="tdCheck" style="vertical-align : middle;">
                                <div style="display:flex;">
                                    <span id="btnSave" name="btnSave" class="btn btn-success btn-sm" style="margin-right: 5px;" onclick="saveVerbo()"><i class="glyphicon glyphicon-ok"></i></span>  
                                    <span id="btnDelete" name="btnDelete" class="btn btn-danger  btn-sm btnDelete" onclick="Deletetr(this)"><i class="glyphicon glyphicon-remove"></i></span>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                </div>
                <button id="btnAdd" class="btn btn-yellow" style="width: 100%;margin-top:-20px" type="button" onclick="Addtr(event)"><span class="glyphicon glyphicon-plus"></span> AGREGAR </button>
            </div>
            <div class="col-sm-12">
                <div class="col-sm-3">
                    <label class="control-label">Tipo de respuesta de la Actividad:</label>
                    <select id="slct_tipo_respuesta" name="slct_tipo_respuesta">
                        <option>Seleccione</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">Detalle de respuesta de la Actividadd:</label>
                    <select id="slct_tipo_respuesta_detalle" name="slct_tipo_respuesta_detalle">
                        <option>Seleccione</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">Descripción de respuesta de la Actividad:</label>
                    <textarea class="form-control" id="txt_observacion" name="txt_observacion" rows="3"></textarea>
                </div>
                <div class="col-sm-3">
                    <label class="control-label">Estado Final de la Actividadd(Alerta):</label>
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
                <div class="col-sm-4">
                    <label class="control-label">Proceso:</label>
                    <input class="form-control" type="text" id="txt_proceso_1" name="txt_proceso_1" readonly>
                </div>
                <div class="col-sm-4">
                    <label class="control-label">Area del Dueño del Proceso:</label>
                    <input class="form-control" type="text" id="txt_area_1" name="txt_area_1" readonly>
                </div>
            </div>
        </div>
        <div class="row form-group" style="display:none" >
            <div class="col-sm-12">
                <div class="box-body table-responsive">
                    <table id="areasasignacion" class="table table-bordered" style="min-height:300px">
                        <thead> 
                            <tr class="head">
                                <th style="width:250px !important;min-width: 200px !important;" >
                                </th>
                                <th class="eliminadetalleg" style="min-width:1000px !important;">[]</th>
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
    
    </div><!-- /.col (RIGHT) -->
    </div>
        <!-- Finaliza contenido -->
</section><!-- /.content -->
@stop
@section('formulario')
    @include( 'admin.reporte.form.expediente' )
    @include( 'admin.ruta.form.ruta' )
    @include( 'admin.ruta.form.ListdocDigital' )
@stop
