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
    @include( 'admin.reporte.js.reportepersonal_ajax' )
    @include( 'admin.reporte.js.reportepersonal' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reporte de Personal
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Personal</li>
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
                                <div class="col-sm-4"></div>
                               
                                <div class="col-sm-2 text-center">
                                    <label class="control-label">Fecha Inicial</label>
                                    <div class="input-group">
                                      <span id="spn_fecha_ini" class="input-group-addon" style="cursor: pointer;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                      <input type="text" class="form-control fecha" placeholder="AAAA-MM" id="fecha_ini" name="fecha_ini" readonly/>
                                    </div>
                                </div>
                              <!--
                                <div class="col-sm-2 text-center">
                                    <label class="control-label">Fecha Final</label>
                                    <div class="input-group">
                                      <span id="spn_fecha_fin" class="input-group-addon" style="cursor: pointer;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                      <input type="text" class="form-control fecha" placeholder="AAAA-MM" id="fecha_fin" name="fecha_fin" readonly/>
                                    </div>
                                </div>
                              -->
                                <div class="col-sm-1" style="padding:24px">
                                    <span class="btn btn-primary btn-md" id="generar" name="generar"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                                </div>
                                <div class="col-sm-1" style="padding:24px">
                                  <!--
                                    <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
                                  -->
                                </div>
                            </div>
                    </div>
                    
                </fieldset>
              
              
                  <div class="row form-group" id="reporte" >
                    <div class="col-sm-12">
                      <div class="box-body table-responsive">
                         <table id="t_ordenest" class="table table-bordered">
                            <thead>
                                <th colspan="8">&nbsp;</th>
                                <th colspan="1">SISTRADOC</th>
                                <th colspan="1">SIGAWEB</th>
                                <th colspan="4">ACTIVIDADES</th>
                                <th colspan="3">PROCESOS</th>
                                <th colspan="3">&nbsp;</th>
                                <th colspan="6">PAPELETAS</th>
                            </thead>
                            <thead>
                               <tr style="font-size: 12px;">
                                   <th width="4%">NRO.</th>
                                   <th width="5%">Area</th>
                                   <th width="5%">Nombres</th>
                                   <th width="5%">Dni</th>
                                   <th width="5%">Cargo</th>
                                   <th width="5%">Funciones</th>
                                   <th width="6%">Estado</th>
                                   <th width="6%">Sueldo</th>
                                   <th width="6%">Doc. Emit</th>
                                   <th width="4%">Doc</th>
                                    <th width="3%">Cant</th>
                                    <th width="6%">Hora</th>
                                    <th width="6%">Dcso</th>
                                    <th width="6%">%</th>
                                   <th width="5%">Cnt Pro</th>
                                   <th width="5%">D Pro</th>
                                   <th width="5%">uso</th>
                                   <th width="5%">ft</th>
                                   <th width="5%">trd</th>
                                   <th width="5%">Per</th>
                                   <th width="5%">C.</th>
                                   <th width="5%">Cta.</th>
                                   <th width="5%">Essld</th>
                                   <th width="5%">Perm</th>
                                   <th width="5%">Compem</th>
                                   <th width="5%">Ono</th>
                               </tr>
                            </thead>
                            <tbody id="tb_ordenest"></tbody>
                         </table>
                        </div>
                    </div>
                 </div>
              </form>

      </div>
      <!-- Finaliza contenido -->

  </section><!-- /.content -->
  

@stop
@section('formulario')
     <!-- @include( 'admin.reporte.form.produccionperxarea' ) -->
@stop
