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

    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}

    {{ HTML::script('lib/jquery.validate.js') }}
    <script src='lib/recaptcha/api.js'></script>

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.ruta.js.tramitedocu_ajax' )
    @include( 'admin.ruta.js.tramitedocu' )
    @include( 'admin.ruta.js.ruta_ajax' )
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
              <h3>Tramite Documentario</h3>

              <form id="FormCrearPreTramite" method="post">
                <div class="col-md-12" style="margin-top:10px">
                    <div class="col-md-2" style="padding-top: 5px;">
                      <span>TIPO: </span>
                    </div>
                    <div class="col-md-3">
                      <select class="form-control" id="cbo_tipodocumento" name="cbo_tipodocumento">
                          <option value>.::Seleccione::.</option>
                          <option value="1">Documento Simple</option>
                          <option value="2">Expediente</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      
                    </div>
                </div>
                <div class="col-md-12 tipoSolicitante" style="margin-top:10px">
                    <div class="col-md-2" style="padding-top: 5px">
                        <span>TIPO SOLICITANTE:</span>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="cbo_tiposolicitante" name="cbo_tiposolicitante">
                              <option value="-1">Selecciona</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <span class="btn btn-primary btn-sm" id="btnTipoSolicitante">BUSCAR TIPO SOLICITANTE</span>
                    </div>

<!--                    <div class="persona hidden">
                      <div class="col-md-2">
                        <span>SELECCIONE PERSONA:</span>
                      </div>
                      <div class="col-md-3">
                        <select class="form-control" id="cbo_persona" name="cbo_persona" onchange="selectUser(this)">
                              <option value="-1">Selecciona</option>
                        </select>
                      </div>
                      <div class="col-md-1">
                        <span class="btn btn-success btn-sm">Agregar Persona <i class="glyphicon glyphicon-plus"></i></span>
                      </div>
                    </div>
                    <div class="emp hidden">
                      <div class="col-md-2">
                        <span>SELECCIONE EMPRESA:</span>
                      </div>
                      <div class="col-md-3">
                        <select class="form-control" id="cbo_empresa" name="cbo_empresa" onchange="">
                              <option value="-1">Selecciona</option>
                        </select>
                      </div>
                      {{-- <div class="col-md-1">
                        <span class="btn btn-success btn-sm">Agregar Empresa <i class="glyphicon glyphicon-plus"></i></span>
                      </div> --}}
                    </div>-->
                </div>

                <div class="col-md-12" style="margin-top:10px">
                    <div class="col-md-2" style="padding-top: 5px;">
                      <span>TIPO TRAMITE: </span>
                    </div>
                    <div class="col-md-3">
                      <select class="form-control" id="cbo_tipotramite" name="cbo_tipotramite">
                          <option value="-1">Selecciona</option>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <span class="btn btn-primary btn-sm" onclick="consultar()">BUSCAR TIPO DE TRÁMITE</span>
                    </div>
                </div>

                <div class="col-md-12" style="padding: 2% 6% 1% 4%;">
                  <fieldset style="max-width: 100% !important;border: 3px solid #ddd;padding: 15px;">
                    <div class="col-md-12 form-group">
                      <div class="col-md-7">
                        <div class="col-md-4">
                          <span>NOMBRE TRAMITE: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_nombretramite" id="txt_nombretramite" class="form-control" disabled>
                          <input type="hidden" name="txt_idclasitramite" id="txt_idclasitramite" class="form-control">
                          <input type="hidden" name="txt_idarea" id="txt_idarea" class="form-control">
                          <input type="hidden" name="txt_persona_id" id="txt_persona_id">
                        </div>
                      </div>
                      <div class="col-md-5  form-group">
                        <div class="col-md-5">
                          <span>NUMERO DE FOLIO: </span>
                        </div>
                        <div class="col-md-7">
                          <input type="text" name="txt_numfolio" id="txt_numfolio" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-7">
                        <div class="col-md-4" style="padding-top: 5px;">
                          <span>TIPO DOCUMENTO: </span>
                        </div>
                        <div class="col-md-8">
                          <select class="form-control" id="cbo_tipodoc" name="cbo_tipodoc">
                              <option value="-1">Selecciona</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-5  form-group">
                        <div class="col-md-5">
                          <span>NUMERO TIPO DOCUMENTO: </span>
                        </div>
                        <div class="col-md-7">
                          <input type="text" name="txt_tipodoc" id="txt_tipodoc" class="form-control">
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>

                 <div class="col-md-12 empresa hidden" style="padding: 2% 6% 1% 4%;">
                  <fieldset style="max-width: 100% !important;border: 3px solid #ddd;padding: 15px;">
                    <legend style="width: 8%">Empresa</legend>
                    <div class="col-md-12 form-group">
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>RUC: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="hidden" name="txt_idempresa" id="txt_idempresa" class="form-control">
                          <input type="text" name="txt_ruc" id="txt_ruc" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>TIPO EMPRESA: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="hidden" name="txt_tipoempresa" id="txt_tipoempresa" class="form-control" disabled>
                          <input type="text" name="txt_tipo" id="txt_tipo" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-group">
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>RAZON SOCIAL: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_razonsocial" id="txt_razonsocial" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>NOMBRE COMERCIAL: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_nombcomercial" id="txt_nombcomercial" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-group">
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>DOMICILIO FISCAL: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_domiciliofiscal" id="txt_domiciliofiscal" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>TELEFONO: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_emptelefono" id="txt_emptelefono" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-group">
                      <div class="col-md-3">
                        <div class="col-md-6">
                          <span>FECHA VIGENCIA: </span>
                        </div>
                        <div class="col-md-6">
                          <input type="text" name="txt_empfechav" id="txt_empfechav" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>REPRES. LEGAL: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_reprelegal" id="txt_reprelegal" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="col-md-5">
                          <span>REPRESE. DNI: </span>
                        </div>
                        <div class="col-md-7">
                          <input type="text" name="txt_repredni" id="txt_repredni" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>

                 <div class="col-md-12 usuarioSeleccionado hidden" style="padding: 2% 4% 2% 4%;">
                  <fieldset style="max-width: 100% !important;border: 3px solid #ddd;padding: 15px;">
                     <legend style="width: 7%">Usuario</legend>
                    <div class="col-md-12 form-group">
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>DNI: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_userdni2" id="txt_userdni2" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>NOMBRE: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_usernomb2" id="txt_usernomb2" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-group">
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>APELLIDO PATERNO: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_userapepat2" id="txt_userapepat2" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>APELLIDO MATERNO: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_userapemat2" id="txt_userapemat2" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-group">
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>TELEFONO: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_usertelf2" id="txt_usertelf2" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>DIRECCION: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_userdirec2" id="txt_userdirec2" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>


                <div class="col-md-12 usuario" style="padding: 2% 4% 2% 4%;">
                  <fieldset style="max-width: 100% !important;border: 3px solid #ddd;padding: 15px;">
                    <legend style="width: 8%">Operador</legend>
                    <div class="col-md-12 form-group">
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>DNI: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_userdni" id="txt_userdni" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>NOMBRE: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_usernomb" id="txt_usernomb" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-group">
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>APELLIDO PATERNO: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_userapepat" id="txt_userapepat" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>APELLIDO MATERNO: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_userapemat" id="txt_userapemat" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 form-group">
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>TELEFONO: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_usertelf" id="txt_usertelf" class="form-control" disabled>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <span>DIRECCION: </span>
                        </div>
                        <div class="col-md-8">
                          <input type="text" name="txt_userdirec" id="txt_userdirec" class="form-control" disabled>
                        </div>
                      </div>
                    </div>
                  </fieldset>
                </div>


               

                <div class="col-md-12 form-group" style="text-align: right;padding-right: 4%;">                  
                  <span class="btn btn-primary btn-sm" onclick="generarPreTramite()">GENERAR</span>
                {{--   <input type="submit" class="btn btn-primary btn-sm btnAction" id="" value="Guardar" onclick="generarPreTramite()"> --}}
                  {{-- <span class="btn btn-primary btn-sm">CANCELAR</span>              --}}   
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
