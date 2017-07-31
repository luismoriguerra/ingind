<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    <!-- {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }} -->

    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    {{ Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
    {{ Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
    {{ Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.contabilidad.js.reportegastos_ajax' )
    @include( 'admin.contabilidad.js.reportegastos' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Detalle de Gastos
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Detalle de Gastos</li>
        </ol>
    </section>

      <!-- Main content -->
      <section class="content">
          <!-- Inicia contenido -->
          <div class="box">
              <form id="form_reporte" name="form_reporte" method="post">
                <fieldset>
                    <div class="row form-group" >
                        <div class="col-sm-12">
                            <div class="col-sm-2 text-center">
                              <label class="control-label">&nbsp;Ruc Proveedor</label>
                              <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></span>
                                <input type="text" class="form-control" placeholder="RUC" name="txt_ruc" id="txt_ruc">
                              </div>
                            </div>

                            <div class="col-md-2 text-center">
                              <label class="control-label">&nbsp;Expediente</label>
                              
                              <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></span>
                                <input type="text" class="form-control" placeholder="00000000000" name="txt_nro_expede" id="txt_nro_expede">
                              </div>
                            </div>

                            <div class="col-md-3 text-center">
                              <label class="control-label">&nbsp;Nombre Proveedor</label>
                              
                              <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></span>
                                <input type="text" class="form-control" placeholder="NOMBRE" name="txt_proveedor" id="txt_proveedor">
                              </div>
                            </div>
                            <div class="col-md-3 text-center">
                              <label class="control-label">&nbsp;Observaci&oacute;n</label>
                              <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span></span>
                                <input type="text" class="form-control" placeholder="OBSERVACION" name="txt_observacion" id="txt_observacion">
                              </div>
                            </div>

                             <div class="col-md-2">                            
                                <label class="control-label" style="margin-top: 28px;">&nbsp;</label>

                                <button type="button" class="btn btn-primary" id="generar" name="generar">
                                  <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar
                                </button>&nbsp;
                                <button type="button" class="btn btn-default" id="limpiar" name="limpiar">
                                  <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                                </button>
                             </div>
                        </div>
                    </div>

                    <div class="row form-group" >
                        <div class="col-md-12">
                            <div class="col-md-3"></div>
                            <label class="col-sm-1 control-label text-right" style="padding-top: 8px; padding-right: 0px;">Fechas</label>
                            <div class="col-md-2">                
                                <div class="input-group">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                  <input type="text" class="form-control fechas" placeholder="INICIO" id="fecha_ini" name="fecha_ini"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                  <input type="text" class="form-control fechas" placeholder="FINAL" id="fecha_fin" name="fecha_fin" />
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                    
                </fieldset>
              
              
                  <div class="row form-group" id="tramite_asignado" >
                    <div class="col-sm-12">
                      <div class="box-body table-responsive">
                         <table id="t_ordenest_" class="table table-bordered">
                            <thead>
                               <tr>
                                   <th width="4%">&nbsp;</th>
                                   <th width="10%">Expediente</th>
                                   <th width="6%">Fase</th>
                                   <th width="11%">Monto S/.</th>
                                   <th width="10%">Fecha Doc.</th>
                                   <th>Documento</th>
                                   <th>Ruc</th>
                                   <th>Proveedor</th>
                                   <!-- <th>Observaci&oacute;n</th> -->
                               </tr>
                            </thead>
                            <tbody id="tb_ordenest"></tbody>
                         </table>
                        </div>
                    </div>
                 </div>
              </form>


              <div class="row form-group" id="div_detalle" >

                <div class="col-sm-12">
                  <h4 style="padding: 4px 12px; color: #666666;">MONTOS TOTALES </h4>
                  <div class="box-body table-responsive">
                     <table id="" class="table table-bordered">
                        <thead>
                           <tr>
                               <th width="10%">Expediente</th>
                               <th width="12%">T. Monto</th>
                               <th width="12%">T. Comprometido</th>
                               <th width="12%">T. Devengado</th>
                               <th width="12%">T. Girado</th>
                               <th width="12%">F.C</th>
                               <th width="12%">F.D</th>
                               <th width="12%">F.G</th>
                           </tr>
                        </thead>
                        <tbody id="tb_deta"></tbody>
                     </table>
                    </div>
                </div>
             </div>

      </div>
      <!-- Finaliza contenido -->

  </section><!-- /.content -->
  

@stop
@section('formulario')
     <!-- @include( 'admin.reporte.form.produccionperxarea' ) -->
@stop
