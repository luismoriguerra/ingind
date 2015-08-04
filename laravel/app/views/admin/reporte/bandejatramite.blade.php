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
    @include( 'admin.reporte.js.bandejatramite_ajax' )
    @include( 'admin.reporte.js.bandejatramite' )
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
            Vista de estados de los trámites por área
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Vista de estados de los trámites por área</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->

            <div class="mailbox row">
                <div class="col-md-12">
                    <div class="row pad">
                        <div class="col-sm-4">
                            <label class="control-label">Tipo:</label>
                            <select class="form-control" name="slct_tipo_visualizacion" id="slct_tipo_visualizacion" multiple>
                            </select>
                        </div>
                    </div><!-- /.row -->
                    <div class="row form-group" id="reporte" >
                        <div class="col-sm-12">
                            <div class="box-body table-responsive">
                            <!-- THE MESSAGES -->
                                <table class="table table-mailbox" id="t_reporte">
                                    <thead>
                                        <tr>
                                            
                                            <th></th>
                                            <th>Tramite</th>
                                            <th>Tiempo</th>
                                            <th>Fecha Inicio</th>
                                            <th>Paso</th>
                                            <th>Fecha tramite</th>
                                            <th>Nombre</th>
                                            <th>Respuesta</th>
                                            <th>observacion</th>
                                            <th>Tipo solicitante</th>
                                            <th>Solicitante</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="tb_reporte">
                                        
                                        
                                    </tbody>
                                </table>
                            </div><!-- /.table-responsive -->
                        </div>
                    </div>
                    <form name="form_ruta_detalle" id="form_ruta_detalle" method="POST" action="">
                        <div class="row form-group" id="reporte_detalle" style="display:none;">
                            <div class="col-sm-12">
                                <h1><span id="txt_titulo2">Detalle</span>
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
                                <!--div class="col-sm-3">
                                    <label class="control-label">Tiempo Final:</label>
                                    <input type="text" class="form-control" id="txt_respuesta" name="txt_respuesta" readonly>
                                </div-->
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
@stop
