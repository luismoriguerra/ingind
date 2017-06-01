<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::style('lib/jquery-bootstrap-validator/bootstrapValidator.min.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    {{ HTML::script('lib/jquery-bootstrap-validator/bootstrapValidator.min.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.ruta.js.ruta_ajax' )
    @include( 'admin.ruta.js.validar_ajax' )
    @include( 'admin.ruta.js.tramiteanexov_ajax' )
    @include( 'admin.ruta.js.tramiteanexov' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<style type="text/css">
.box{
    border: 2px solid #c1c1c1;
    border-radius: 5px;
}
.filtros{
    margin-top: 10px;
    margin-bottom: 0px;
}
.right {
    text-align: right;
}
td, th{
    text-align:center;
}

.form-control{
    border-radius: 5px !important;
}
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

.btn-yellow{
    color: #0070ba;
    background-color: ghostwhite;
    border-color: #ccc;
    font-weight: bold;
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
            Listado de Tramites
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Listado de Tramites</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <div class="box">
                <fieldset>
                    <div class="row form-group filtros" >
                        <div class="col-sm-12">
                            <div class="col-md-4 col-sm-4">
                                <label class="control-label">INGRESAR COD O NOMBRE DEL TRAMITE:</label>
                                <!-- <select class="form-control" name="slct_area_id" id="slct_area_id" multiple>
                                </select> -->
                            </div>
                            <div class="col-md-4 col-sm-4">
                             <!--    <label class="control-label">Estado Proceso:</label>
                                <select class="form-control" name="slct_estado" id="slct_estado" multiple>
                                    <option value="1">Producción</option>
                                    <option value="2">Pendiente</option>
                                </select> -->
                                <input type="text" class="form-control" id="txtbuscar" name="txtbuscar">
                            </div>
                            <div class="col-md-1 col-sm-2">
                                <span class="btn btn-primary btn-md" id="generar" name="generar" onclick="mostrarTramites()"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                            </div>
                          <!--   <div class="col-md-1 col-sm-2">
                                <a class='btn btn-success btn-md' id="btnNuevo" name="btnNuevo" data-toggle="modal" data-target="#addAnexo">Anexo <i class="glyphicon glyphicon-plus"></i></a>
                            </div> -->
                        </div>
                    </div>
                </fieldset>
            </div><!-- /.box -->

            <div class="box-body table-responsive">
                <div class="row form-group" id="reporte">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_reporte" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ITEM</th>
                                        <th>NOMBRE DEL TRAMITE</th>
                                        <th>TRAMITE</th>
                                        <th>FECHA DE INGRESO</th>
                                        <th>USUARIO REGISTRADOR</th>
                                        <th>OBSERVACION</th>
                                        <th>LISTAR ANEXO</th>
                                        <th>VISUALIZADO</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_reporte">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nuevoanexo hidden">
              <div class="col-md-1 col-sm-2">
                  <a class='btn btn-success btn-md' id="btnNuevo" name="btnNuevo" data-toggle="modal" data-target="#addAnexo">Anexo <i class="glyphicon glyphicon-plus"></i></a>
              </div>
            </div>


            <!--- anexos-->
            <div class="anexo hidden">
              <div class="box" style="margin-top: 40px">
                  <fieldset>
                      <div class="row form-group filtros" style="margin-bottom:-5px">
                          <div class="col-sm-12">
                              <div class="col-md-4 col-sm-4">
                                  <label class="control-label">INGRESAR COD O NOMBRE DEL ANEXO:</label>
                              </div>
                              <div class="col-md-4 col-sm-4">
                                  <input type="text" class="form-control" id="txt_anexobuscar" name="txt_anexobuscar">
                                  <input type="hidden" id="txt_idtramite" name="txt_idtramite" value="">
                              </div>
                              <div class="col-md-1 col-sm-2">
                                  <span class="btn btn-primary btn-md" id="generarAnexo" name="generarAnexo" onclick="buscarAnexo()"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                              </div>
                             {{--  <div class="col-md-1 col-sm-2">
                                  <a class='btn btn-success btn-md' id="btnNuevo" name="btnNuevo" data-toggle="modal" data-target="#addAnexo">Anexo <i class="glyphicon glyphicon-plus"></i></a>
                              </div> --}}
                          </div>
                      </div>
                  </fieldset>
              </div>
              <br>

              <div class="box-body table-responsive">
                  <div class="row form-group" id="reporte">
                      <div class="col-sm-12">
                          <div class="box-body table-responsive">
                              <table id="t_anexo" class="table table-bordered">
                                  <thead>
                                      <tr>
                                          <th>COD</th>
                                          <th>NOMBRE DEL ANEXO</th>
                                          <th>FECHA DE INGRESO</th>
                                          <th>USUARIO REGISTRADOR</th>
                                          <th>OBSERVACION</th>
                                          <th>AREA</th>
                                          <th>DETALLE</th>
                                          <th>VOUCHER</th>
                                          <th>EDITAR</th>
                                          <th>ELIMINAR</th>
                                      </tr>
                                  </thead>
                                  <tbody id="tb_anexo">
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <!-- anexos-->

                </div><!-- /.col (RIGHT) -->
            </div>
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
@stop
@section('formulario')
   {{--   @include( 'admin.ruta.form.anexos' ) --}}
     @include( 'admin.ruta.form.estadoTramite' )
     @include( 'admin.ruta.form.estadoAnexo' )
     @include( 'admin.ruta.form.agregarAnexo' )
     @include( 'admin.ruta.form.voucheranexo' )
     @include( 'admin.ruta.form.empresasbyuser' )
     @include( 'admin.ruta.form.selectPersona' )
@stop
