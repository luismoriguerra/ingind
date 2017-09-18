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
    border:1px solid #d3d3d3;
    background:#fefefe;
    -moz-border-radius:5px; /* FF1+ */
    -webkit-border-radius:5px; /* Saf3-4 */
    border-radius:5px;
    -moz-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
    -webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
}
th, td {padding:18px 28px 18px; text-align:center; }
th {padding-top:22px; text-shadow: 1px 1px 1px #fff; background:#e8eaeb;}
td {border-top:1px solid #e0e0e0; border-right:1px solid #e0e0e0;}
tr.odd-row td {background:#f6f6f6;}
td.first, th.first {text-align:left}
td.last {border-right:none;}
/*
Background gradients are completely unnecessary but a neat effect.
*/
td {
    background: -moz-linear-gradient(100% 25% 90deg, #fefefe, #f9f9f9);
    background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f9f9f9), to(#fefefe));
}
tr.odd-row td {
    background: -moz-linear-gradient(100% 25% 90deg, #f6f6f6, #f1f1f1);
    background: -webkit-gradient(linear, 0% 0%, 0% 25%, from(#f1f1f1), to(#f6f6f6));
}
th {
    background: -moz-linear-gradient(100% 20% 90deg, #e8eaeb, #ededed);
    background: -webkit-gradient(linear, 0% 0%, 0% 20%, from(#ededed), to(#e8eaeb));
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
                                <div class="col-sm-4"></div>
                               
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
                              
                                <div class="col-sm-3" style="padding:24px">
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
                         <table id="t_ordenest" class="table table-bordered table_nv">
                            <thead>
                                <th colspan="8">&nbsp;</th>
                                <!-- <th colspan="1">SISTRADOC</th>
                                <th colspan="1">SIGAWEB</th> -->
                                <th colspan="4">ACTIVIDADES</th>
                                <th colspan="3">PROCESOS</th>
                                <th colspan="3">&nbsp;</th>
                                <th colspan="6">PAPELETAS</th>
                            </thead>
                            <thead>
                               <tr class="active" style="font-size: 12px;">
                                   <th width="4%">NRO.</th>
                                   <th width="5%">Area</th>
                                   <th width="5%">Nombres</th>
                                   <th width="5%">Dni</th>
                                   <th width="5%">Cargo</th>
                                   <th width="5%">Condición</th>
                                   <th width="6%">Faltas</th>
                                   <th width="6%">D. Ftas</th>
                                   
                                   <th width="6%">Trd</th>
                                   <th width="4%">Slsg</th>
                                    <th width="3%">D. slsg</th>
                                    <th width="6%">Sancion Dici</th>

                                    <th width="6%">D. sdsg</th>
                                    <th width="6%">Lic. Sindical</th>
                                   <th width="5%">D. Ls</th>

                                   <th width="5%">Dcso. Med</th>
                                   <th width="5%">D. Dcso. Med</th>
                                   <th width="5%">Min. Perm</th>

                                   <th width="5%">Com.</th>
                                   <th width="5%">Cit.</th>
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
