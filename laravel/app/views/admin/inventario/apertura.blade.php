<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::style('http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css') }}

    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    {{ HTML::script('http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js') }}

    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }} 
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}

    {{ HTML::script('http://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.js') }}
    {{ HTML::style('lib/datepicker.css') }}
    {{ HTML::script('lib/bootstrap-datepicker.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
{{--     @include( 'admin.ruta.js.ruta_ajax' )
    @include( 'admin.ruta.js.validar_ajax' ) --}}
    @include( 'admin.inventario.js.apertura_ajax' )
    @include( 'admin.inventario.js.apertura' )
{{--     @include( 'admin.ruta.js.ruta_ajax' ) --}}
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

    fieldset{
        max-width: 100% !important;
        border: 3px solid #999;
        padding:10px 20px 2px 20px;
        border-radius: 10px; 
    }

    .margin-top-10{
         margin-top: 10px;   
    }

    .margin-top-5{
      margin-top: 5px;   
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

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->

            <div class="crearPreTramite">
              <h3>Aperturar Inventario</h3>
                <div class="col-md-12 margin-top-10 form-group">
                  <div class="row">
                    <div class="col-md-9">
                      <div class="col-md-2"><span>ENTIDAD: </span></div>
                      <div class="col-md-10">
                        <input type="text" class="form-control" name="txt_entidad" id="txt_entidad" value="MUNICIPALIDAD DISTRITAL DE INDEPENDENCIA" readonly="readonly" style="text-align: center">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="col-md-2"><span>FECHA: </span></div>
                      <div class="col-md-10">
                        <input type="text" class="form-control" name="txt_fecha" id="txt_fecha" value="" readonly="readonly">
                      </div>
                    </div>    
                  </div>
                </div>

                <div class="col-md-12 form-group">
                  <form id="FormAperturaActualizar" method="post">
                    <fieldset>
                      <input type="text" name="txt_idapertura" id="txt_idapertura" class="form-control hidden" value="">
                      <div class="row form-group">
                        <div class="col-md-6">
                          <div class="col-md-4">
                            <span>FECHA INICIO: </span>
                          </div>
                          <div class="col-md-8">
                            <input type="text" name="txt_fechainicioA" id="txt_fechainicioA" class="form-control datepickerActual" value="" disabled>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="col-md-4">
                             <span>FECHA FINAL: </span>
                          </div>
                          <div class="col-md-8">
                            <input type="text" name="txt_fechafinalA" id="txt_fechafinalA" class="form-control datepickerActual" value="" disabled>
                          </div> 
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-12">
                          <div class="col-md-2">
                            <span>OBSERVACION: </span>
                            <br><br>
                            <span class="btnDesbloquear btn btn-primary btn-sm" onclick="desbloquear()"><i class="glyphicon glyphicon-edit"></i> EDITAR</span>
                            <span class="btnActualizar btn btn-success btn-sm hidden" onclick="actualizar()"><i class="glyphicon glyphicon-edit"></i> ACTUALIZAR</span>
                          </div>
                          <div class="col-md-10">
                            <textarea class="form-control" id="txt_observacionA" name="txt_observacionA" rows="3" readonly="readonly"></textarea>
                            <!-- <input type="text" name="txt_dependencia" id="txt_dependencia" class="form-control" value=""> -->
                          </div>
                        </div>
                      </div>
                    </fieldset>
                  </form>
                </div>


                <form id="FormApertura" method="post">
                <div class="col-md-12 form-group">
                  <fieldset>
                    <div class="row form-group">
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>FECHA INICIO: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_fechainicio" id="txt_fechainicio" class="form-control datepicker" value="">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-4">
                           <span>FECHA FINAL: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_fechafinal" id="txt_fechafinal" class="form-control datepicker" value="">
                        </div> 
                      </div>
                    </div>
                    <div class="row form-group">
                      <div class="col-md-12">
                        <div class="col-md-2">
                          <span>OBSERVACION: </span>
                        </div>
                        <div class="col-md-10">
                          <textarea class="form-control" id="txt_observacion" name="txt_observacion" rows="3"></textarea>
                          <!-- <input type="text" name="txt_dependencia" id="txt_dependencia" class="form-control" value=""> -->
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>

                <div class="col-md-12 form-group" style="text-align: center;">                  
                  <span class="btn btn-success btn-sm" onclick="registrarApertura()" style="width: 28%"><i class="glyphicon glyphicon-plus"></i> GUARDAR</span>
                </div>
              </form>
            </div>

                </div><!-- /.col (RIGHT) -->
            </div>
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
@stop
@section('formulario')
  @include( 'admin.ruta.form.crearUsuario' )
  @include( 'admin.ruta.form.crearEmpresa' )
  @include( 'admin.ruta.form.selectPersona' )
  @include( 'admin.ruta.form.buscartramite' )
  @include( 'admin.ruta.form.empresasbyuser' )
  @include( 'admin.ruta.form.rutaflujo' )
  @include( 'admin.ruta.form.ruta' )
@stop