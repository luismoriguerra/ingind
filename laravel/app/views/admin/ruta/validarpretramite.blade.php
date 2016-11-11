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
    @include( 'admin.ruta.js.validarpretramite_ajax' )
    @include( 'admin.ruta.js.validarpretramite' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<style type="text/css">
.box{
    border: 2px solid #c1c1c1;
    border-radius: 5px;
}

.format{
    border: 1px solid grey;
    border-radius: 8px;
    padding: 2% 2% 0% 2%;
    margin-bottom: 2%;
}

.filtros{
    margin-top: 10px;
    margin-bottom: 0px;
}

.right{
  text-align: right;
}

td, th{
    text-align:center;
}
  
.modal-body label,.modal-body span{
  font-size: 13px;
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
            Recepcion de Pre Tramite           
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
         

            <div class="box-body">
                <div class="row form-group" id="">
                    <div class="col-sm-10">
                        <div class="row form-group" >
                           <div class="col-sm-12">
                            <div class="col-sm-2">
                                <label class="control-label">CODIGO PRE TRAMITE: </label>
                             </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" placeholder="2341" id="txt_codpt" name="txt_codpt"/>
                              
                            </div>
                            <div class="col-sm-3">
                                <span class="btn btn-primary btn-md" onclick="Detallepret()"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-12 format">
                          <div class="row">
                            <div class="col-sm-10">
                               <div class="row form-group">
                                  <div class="col-sm-4">
                                      <label>TIPO TRAMITE: </label>
                                      <span id="spanTipoT"></span>
                                  </div>
                                   <div class="col-sm-4">
                                      <label>TIPO DOCUMENTO: </label>
                                      <span id="spanTipoD"></span>
                                  </div>
                                   <div class="col-sm-4">
                                      <label>#TIPO DOC: </label>
                                      <span id="spanNumTP"></span>
                                  </div>
                               </div>
                               <div class="row form-group">
                                  <div class="col-sm-4">
                                      <label>TIPO SOLICITANTE: </label>
                                      <span id="spanTSoli"></span>
                                  </div>
                                   <div class="col-sm-4">
                                      <label>#FOLIO: </label>
                                      <span id="spanFolio"></span>
                                  </div>
                               </div>
                            </div>
                            <div class="col-sm-2">
                                <input type="file" name="txt_file" id="txt_file" style="display: none">
                                <span class="btn btn-primary btn-sm" id="btnImage" name="btnImage" style="width: 100%">CARGAR IMAGEN</span>
                                <span id="spanNombreAdjunto" class="hidden"></span>
                                <img class="imgSlide" src="assets/images/agregar.png" style="height:auto;width:100%;border:1px solid;" />         
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-12 cliente format">
                          <div class="row form-group">
                            <div class="col-sm-4">
                              <label style="color:red">DATOS CLIENTE (*)</label>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-sm-4">
                              <label>NOMBRE: </label>
                              <span id="spanNombreU"></span>
                            </div>
                            <div class="col-sm-4">
                              <label>TIPO DOCUMENTO IDENT: </label>
                              <span id="spanTipoDIU"></span>
                            </div>                            
                          </div>
                          <div class="row form-group">
                            <div class="col-sm-4">
                              <label>PATERNO: </label>
                              <span id="spanPaternoU"></span>
                            </div>
                            <div class="col-sm-4">
                              <label>MATERNO: </label>
                              <span id="spanMaternoU"></span>
                            </div>
                            <div class="col-sm-4">
                              <label>#DOCUMENTO IDENT: </label>
                              <span id="spanDNIU"></span>
                            </div>                            
                          </div>
                        </div>

                         <div class="col-sm-12 empresa format hidden">
                          <div class="row form-group">
                            <div class="col-sm-4">
                              <label style="color:red">DATOS EMPRESA (*)</label>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-sm-4">
                              <label>TIPO EMPRESA: </label>
                              <span id="spanTE"></span>
                            </div>
                            <div class="col-sm-4">
                              <label>RAZON SOCIAL: </label>
                              <span id="spanRazonS"></span>
                            </div>
                            <div class="col-sm-4">
                              <label>DIRECCION: </label>
                              <span id="spanDF"></span>
                            </div>                            
                          </div>
                          <div class="row form-group">
                            <div class="col-sm-4">
                              <label>RUC: </label>
                              <span id="spanRUC"></span>
                            </div>
                            <div class="col-sm-4">
                              <label>REPRESENTANTE: </label>
                              <span id="spanRepresentante"></span>
                            </div>
                            <div class="col-sm-4">
                              <label>#TELEFONO: </label>
                              <span id="spanTelefono"></span>
                            </div>                            
                          </div>
                        </div>

                        <div class="col-sm-12 clasificacion format">
                          <div class="row form-group">
                            <div class="col-sm-4">
                              <label style="color:red">CLASIFICACION DEL TRAMITE (*)</label>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-sm-5">
                              <label>NOMBRE DEL TRAMITE: </label>
                              <span id="spanNombreT"></span>
                            </div>
                            <div class="col-sm-5">
                              <label>AREA: </label>
                              <span id="spanArea"></span>
                            </div>
                            <div class="col-sm-2">                              
                              <span class="btn btn-primary btn-sm" id="spanEditar" onclick="getCTramites()" style="width: 100%">Editar</span>
                            </div>                          
                          </div>
                        </div>

                        <div class="col-sm-12 observacion format">
                          <div class="row form-group">
                            <div class="col-sm-4">
                              <label style="color:red">OBSERVACIONES (*)</label>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <textarea class="form-control" id="txt_observaciones" name="txt_observaciones" rows="4"></textarea>
                            </div>                     
                          </div>
                        </div>

                        <div class="col-sm-12">
                          <div class="row">
                            <div class="col-md-6">
                              <span class="btn btn-primary btn-sm" style="float: right;">GRABAR</span>
                            </div>
                            <div class="col-md-6">
                              <span class="btn btn-primary btn-sm">CANCELAR</span>
                            </div>
                          </div>
                        </div>

                    </div>
                </div>
            </div>

                </div><!-- /.col (RIGHT) -->
            </div>
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
@stop
@section('formulario')
  @include( 'admin.ruta.form.detallepretramite' )
  @include( 'admin.ruta.form.voucherpretramite' )
  @include( 'admin.ruta.form.buscartramite' )
  @include( 'admin.ruta.form.empresasbyuser' )
@stop
