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
    @include( 'admin.ruta.js.validar_ajax' )
    @include( 'admin.reporte.js.bandejatramitearea_ajax' )
    @include( 'admin.reporte.js.bandejatramitearea' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<style type="text/css">
    /*
    Component: Mailbox
*/
.mailbox .table-mailbox {
  border-left: 1px solid #ddd;
  border-right: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
}
.mailbox .table-mailbox tr.unread > td {
  background-color: rgba(0, 0, 0, 0.05);
  color: #000;
  font-weight: 600;
}
.mailbox .table-mailbox .unread
/*.mailbox .table-mailbox tr > td > .fa.fa-ban,*/
/*.mailbox .table-mailbox tr > td > .glyphicon.glyphicon-star,
.mailbox .table-mailbox tr > td > .glyphicon.glyphicon-star-empty*/ {
  /*color: #f39c12;*/
  cursor: pointer;
}
.mailbox .table-mailbox tr > td.small-col {
  width: 30px;
}
.mailbox .table-mailbox tr > td.name {
  width: 150px;
  font-weight: 600;
}
.mailbox .table-mailbox tr > td.time {
  text-align: right;
  width: 100px;
}
.mailbox .table-mailbox tr > td {
  white-space: nowrap;
}
.mailbox .table-mailbox tr > td > a {
  color: #444;
}
@media screen and (max-width: 767px) {
  .mailbox .nav-stacked > li:not(.header) {
    float: left;
    width: 50%;
  }
  .mailbox .nav-stacked > li:not(.header).header {
    border: 0!important;
  }
  .mailbox .search-form {
    margin-top: 10px;
  }
}
</style>
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
                             <div class="col-md-12">
                                <div class="col-md-4 col-sm-4" style="padding:24px">
                                    <select name="slct_areas" id="slct_areas" onChange="Bandeja.MostrarAjax();">
                                    </select>

                                </div>
                                <div class="col-md-1 col-sm-2" style="padding:24px">
                                {{-- <span class="btn btn-success btn-md" id="btnexport" name="btnexport"><i class="glyphicon glyphicon-download-alt"></i> Export</span> --}}
                                <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target=""><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
                                {{-- <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="mostrar"> --}}
                            </div>
                            </div>
                                <br><br>
                                
                                <table id="t_reporte_ajax" class="table table-mailbox">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th id="th_r" style='width:250px !important;' class="unread">Responsable
                                            <input style='width:250px' name="txt_id_res" id="txt_id_res" onBlur="MostrarAjax();" onKeyPress="return enterGlobal(event,'th_r',1)" onkeyup="Limpiar('txt_id_union,#txt_solicitante,#txt_proceso');" type="text" placeholder="" />
                                            </th>
                                            <th id="th_dg" style='width:250px !important;' class="unread">Documento generado por <br>el paso anterior<br>
                                            <input style='width:250px' name="txt_id_ant" id="txt_id_ant" onBlur="MostrarAjax();" onKeyPress="return enterGlobal(event,'th_dg',1)" onkeyup="Limpiar('txt_id_union,#txt_solicitante,#txt_proceso);" type="text" placeholder="" />
                                            </th>
                                            <th id="th_pd" style='width:250px !important;' class="unread">Primer documento ingresado<br>
                                            <input style='width:250px' name="txt_id_union" id="txt_id_union" onBlur="MostrarAjax();" onKeyPress="return enterGlobal(event,'th_pd',1)" onkeyup="Limpiar('txt_id_ant,#txt_solicitante,#txt_proceso);" type="text" placeholder="" />
                                            </th>
                                            <th>Tiempo</th>
                                            <th id="th_fi" style='width:250px !important;' class="unread">Fecha Inicio<br>
                                            <input style='width:250px' name="txt_fecha_inicio_b" id="txt_fecha_inicio_b" onChange="MostrarAjax();" type="text" />
                                            </th>
                                            <th id="th_ep" style='width:250px !important;' class="unread">Estado del Paso<br>
                                            <select name="slct_tiempo_final" id="slct_tiempo_final" onChange="MostrarAjax();" />
                                            <option value="">.::Todo::.</option>
                                            <option value="1">Dentro del Tiempo</option>
                                            <option value="0">Fuera del Tiempo</option>
                                            </select>
                                            </th>
                                            <th>Paso</th>
                                            <th id="th_pr" style='width:250px !important;' class="unread">Proceso<br>
                                            <input style='width:250px' name="txt_proceso" id="txt_proceso" onBlur="MostrarAjax();" onKeyPress="return enterGlobal(event,'th_pr',1)" onkeyup="Limpiar('txt_id_ant,#txt_id_union,#txt_solicitante);" type="text" placeholder="" />
                                            </th>
                                            <th id="th_so" style='width:250px !important;' class="unread">Solicitante<br>
                                            <input style='width:250px' name="txt_solicitante" id="txt_solicitante" onBlur="MostrarAjax();" onKeyPress="return enterGlobal(event,'th_so',1)" onkeyup="Limpiar('txt_id_ant,#txt_id_union,#txt_proceso);" type="text" placeholder="" />
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Responsable</th>
                                            <th>Doc. Generado por <br>el paso anterior</th>
                                            <th>Primer Doc. ingresado <br>por Mesa de Partes</th>
                                            <th>Tiempo</th>
                                            <th>Fecha Inicio</th>
                                            <th>Estado del Paso</th>
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
                                            <!--a class="btn btn-sm btn-primary" data-toggle="modal" data-id='' data-target="#expedienteModal">
                                                <i class="fa fa-search fa-lg"></i>
                                                .::Expediente::.
                                            </a-->
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
                                            <table class="table table-bordered table-striped">
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
                                                        <th style="text-align:center">Documento Generado</th>
                                                        <th style="text-align:center">Observaciones</th>
                                                        <!--th style="text-align:center">Adjuntar Doc. Generado</th-->
                                                    </tr>
                                                </thead>
                                                <tbody id="t_detalle_verbo"></tbody>
                                            </table>
                                        </div>
                                        <div class="col-sm-12" style="display:none">
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
                                    </div>
                                </form>
                </div><!-- /.col (RIGHT) -->
            </div>
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
@stop
@section('formulario')
     @include( 'admin.reporte.form.bandejatramite' )
     @include( 'admin.reporte.form.expediente' )
@stop
