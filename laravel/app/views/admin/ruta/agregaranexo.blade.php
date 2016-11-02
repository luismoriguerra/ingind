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
    @include( 'admin.ruta.js.tramiteanexo_ajax' )
    @include( 'admin.ruta.js.tramiteanexo' )
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
            Nuevo Anexo
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
                <div class="row form-group">
                  <div class="col-md-12">
                      <div class="col-md-4">
                          <label>Nombre:</label>
                          <input class="form-control" type="text" name="" id="" value="">
                      </div>
                      <div class="col-md-4">
                           <label>Apellido Paterno:</label>
                           <input class="form-control" type="text" name="" id="" value="">
                      </div>
                      <div class="col-md-4">
                            <label>Apellido Materno:</label>
                            <input class="form-control" type="text" name="" id="" value="">
                      </div>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-12">
                      <div class="col-md-4">
                          <label>Tipo Doc.Entidad</label>
                          <input class="form-control" type="text" name="" id="" value="">
                      </div>
                      <div class="col-md-4">
                           <label>Num Doc.Entidad</label>
                           <input class="form-control" type="text" name="" id="" value="">
                      </div>                     
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-12">
                      <div class="col-md-4">
                          <label>Cod. Tramite:</label>
                          <input class="form-control" type="text" name="" id="" value="">
                      </div>
                      <div class="col-md-4">
                           <label>Fecha Ingreso:</label>
                           <input class="form-control" type="text" name="" id="" value="">
                      </div>
                      <div class="col-md-4">
                            <label>#Tipo Doc:</label>
                            <select class="form-control" id="" name=""></select>
                      </div>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-12">
                      <div class="col-md-4">
                          <label>Nombre Tramite:</label>
                          <input class="form-control" type="text" name="" id="" value="">
                      </div>
                      <div class="col-md-4">
                           <label>#Num Documento:</label>
                           <input class="form-control" type="text" name="" id="" value="">
                      </div>
                      <div class="col-md-4">
                           <label>#Folio:</label>
                           <div class="row">
                              <div class="col-md-6">
                                 <input class="form-control" type="text" name="" id="" value="">
                              </div>
                              <div class="col-md-6">
                                 <input class="form-control" type="file" name="" id="" value="" style="display:none">
                                 <span class="btn btn-primary btn-md" name="" id="" value="" style="width: 100%">Cargar Imagen <i class="glyphicon glyphicon-upload"></i></span>
                             </div>
                           </div> 
                      </div>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-12">
                    <div class="col-md-12">
                      <label>Observaciones:</label>
                      <textarea class="form-control" id="" name="" rows="5" placeholder="SE ANEXO EL REQUISITO A ALTRAMITE DE  LICENCIA DE FUNCIONAMIENTO ALIMENTARIO"></textarea>
                    </div>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-12" style="text-align: right">
                      <span class="btn btn-primary btn-md">Guardar <i class="glyphicon glyphicon-ok"></i></span>
                      <span class="btn btn-warning btn-md">Cancelar <i class="glyphicon glyphicon-remove"></i></span>
                  </div>
                </div>

                </div><!-- /.col (RIGHT) -->
            </div>
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
@stop
@section('formulario')
     @include( 'admin.ruta.form.anexos' )
     @include( 'admin.ruta.form.estadoTramite' )
@stop
