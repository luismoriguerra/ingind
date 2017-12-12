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
    @include( 'admin.reporte.js.reportepersonaladm_ajax' )
    @include( 'admin.reporte.js.reportepersonaladm' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
<style type="text/css">
.table_nv {
    overflow:hidden;
    border:1px solid #fefefe;
    background:#fefefe;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:5px;
    -moz-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
    -webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
}
th, td {padding:18px 28px 18px; text-align:center; /*border-color: #666666 !important;*/ }
th {padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;}
td {border-top:1px solid #fefefe; border-right:1px solid #fefefe;}
tr.odd-row td {background:#f6f6f6;}
td.first, th.first {text-align:left}
td.last {border-right:none;}

td {
    background: -moz-linear-gradient(100% 25% 90deg, #fefefe, #f9f9f9);
    background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f9f9f9), to(#fefefe));
}
tr.odd-row td {
    background: -moz-linear-gradient(100% 25% 90deg, #f6f6f6, #f1f1f1);
    background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f1f1f1), to(#f6f6f6));
}
.th_1 {
    background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed); /* #009A0D = #ededed(old) */
    background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#009A0D), to(#e8eaeb));
}

.th_2 {
    background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed);
    background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#0D7BE8), to(#e8eaeb));
}

.th_3 {
    background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed);
    background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#935799), to(#e8eaeb));
}

.th_4 {
    background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed);
    background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#CC9C0D), to(#e8eaeb));
}

tr:first-child th.first {
    -moz-border-radius-topleft:5px;
    -webkit-border-top-left-radius:5px; /* Saf3-4 */
}
tr:first-child th.last {
    -moz-border-radius-topright:5px;
    -webkit-border-top-right-radius:5px; /* Saf3-4 */
}
tr:last-child td.first {
    -moz-border-radius-bottomleft:5px;
    -webkit-border-bottom-left-radius:5px; /* Saf3-4 */
}
tr:last-child td.last {
    -moz-border-radius-bottomright:5px;
    -webkit-border-bottom-right-radius:5px; /* Saf3-4 */
}
</style>

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
                                <div class="col-sm-2"></div>
                               
                                <div class="col-sm-2 text-center">
                                    <label class="control-label">Fecha Inicial</label>
                                    <div class="input-group">
                                      <span id="spn_fecha_ini" class="input-group-addon" style="cursor: pointer;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                      <input type="text" class="form-control fecha" placeholder="AAAA/MM/DD" id="fecha_ini" name="fecha_ini" readonly/>
                                    </div>
                                </div>
                              
                                <div class="col-sm-2 text-center">
                                    <label class="control-label">Fecha Final</label>
                                    <div class="input-group">
                                      <span id="spn_fecha_fin" class="input-group-addon" style="cursor: pointer;"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                                      <input type="text" class="form-control fecha" placeholder="AAAA/MM/DD" id="fecha_fin" name="fecha_fin" readonly/>
                                    </div>
                                </div>
                              
                                <div class="col-sm-3 text-center">
                                    <label class="control-label">Area</label>
                                    <div id="div_areas">                   
                                      <select class="form-control" name="slct_area_ws" id="slct_area_ws">
                                          <option value='0'>.::::::: Seleccione una Opción del listado :::::::.</option>
                                      </select>
                                    </div>                                  
                                </div>

                                <div class="col-sm-1" style="padding:24px; padding-left: 15px;">
                                    <span class="btn btn-primary btn-md" id="generar" name="generar"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                                </div>
                                <div class="col-sm-1" style="padding:24px; padding-left: 0px;">
                                    <!-- <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a> -->
                                    <a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='#'><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
                                </div>
                            </div>
                    </div>
                    
                </fieldset>
              
              
                  <div class="row form-group" id="reporte" >
                    <div class="col-sm-12">
                      <div class="box-body table-responsive">
                         <table id="t_ordenest" class="table table-bordered table_nv">
                            <thead>
                              <tr>
                                <th class="th_1" colspan="7">DATOS PERSONALES</th> <!-- 7 -->
                                <!-- <th colspan="1">SISTRADOC</th>
                                <th colspan="1">SIGAWEB</th> -->
                                <th class="th_2" colspan="7">DETALLES DE ASISTENCIA</th> <!-- 3 ACTIVIDADES -->
                                <!-- <th colspan="3">PROCESOS</th>
                                <th colspan="3">&nbsp;</th> -->
                                <th class="th_3" colspan="6">PERMISOS / PAPELETAS</th>
                                <th class="th_4" colspan="4">PROCESO FLUJOS</th>
                              </tr>
                              
                              <tr class="active" style="font-size: 12px;">
                                  <th width="3%">#</th>
                                  <th width="4%">Foto</th>
                                  <th width="5%">Area</th>
                                  <th width="7%">Nombres</th>
                                  <th width="4%">Dni</th>
                                  <th width="6%">Cargo / Puesto</th>
                                  <th width="6%">Regimen Lab.</th>
                                  <th width="3%">Faltas</th>
                                  <!-- <th width="4%">D. Flts</th> -->
                                  <th width="4%">Trd</th>
                                  <th width="4%">Lic S.G</th>
                                  <!-- <th width="4%">D. slsg</th> -->
                                  <th width="4%">Sancion Dici</th>
                                  <!-- <th width="4%">D. sdsg</th> -->
                                  <th width="4%">Lic. Sindical</th>
                                  <!-- <th width="4%">D. Ls</th> -->
                                  <th width="4%">Dcso. Med</th>
                                  <!-- <th width="4%">D. Dcso. Med</th> -->
                                  <th width="4%">Min. Perm</th>
                                  <th width="4%">Com.</th>
                                  <th width="4%">Cit.</th>
                                  <th width="4%">Essld</th>
                                  <th width="4%">Perm</th>
                                  <th width="4%">Compem</th>
                                  <th width="4%">Ono</th>

                                  <th width="4%">H.Act.</th>
                                  <th width="4%">Tarea</th>
                                  <th width="4%">T.Trami</th>
                                  <th width="4%">Doc</th>
                               </tr>
                            </thead>
                            <tbody id="tb_ordenest">
                              <!-- <tr style='font-size: 13px;'><td colspan='23'>Por favor realice una busqueda.</td></tr> -->
                            </tbody>
                         </table>
                          <br>
                          <table id="t_regimen" class="table table-bordered" style="width:40%">
                            <thead>
                              <tr>
                                <th>RÉGIMEN</th> <!-- 7 -->
                                <th>CANTIDAD</th> <!-- 3 ACTIVIDADES -->
                              </tr>
                            </thead>
                            <tbody id="tb_regimen">
                            </tbody>
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
