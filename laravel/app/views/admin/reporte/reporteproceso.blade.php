<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
@parent

{{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
{{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

{{ Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js') }}
{{ Html::style('lib/jquery-treegrid/css/jquery.treegrid.css') }}
{{ Html::script('lib/jquery-treegrid/js/jquery.treegrid.js') }}
{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js') }}
{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js') }}

{{ HTML::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyCxS6Bw_xqMl2zaSOgplzZtzhgx6L8QYkY') }}
{{ HTML::script('lib/gmaps.js') }}

@include( 'admin.js.slct_global_ajax' )
@include( 'admin.js.slct_global' )
@include( 'admin.reporte.js.reporteproceso_ajax' )
@include( 'admin.reporte.js.reporteproceso' )
@include( 'admin.ruta.js.proceso' )
@include( 'admin.ruta.js.asignar_ajax' )
@include( 'admin.ruta.js.ruta_ajax' )
@include( 'admin.reporte.js.totaltramites_ajax' )
@include( 'admin.reporte.js.personalizado_ajax' )
@include( 'admin.reporte.js.personalizado' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<style type="text/css">
    .btn-yellow{
        color: #0070ba;
        background-color: ghostwhite;
        border-color: #ccc;
        font-weight: bold;
    }

    .yellow-fieldset{
        max-width: 100% !important;
        border: 3px solid #999;
        padding:10px 20px 2px 20px;
        border-radius: 10px; 
    }

    .margin-top-10{
        margin-top: 10px;   
    }
</style>

<style type="text/css">
/* GOOGLE MAPS */
#map{
  display: block;
  width: 98%;
  height: 500px;
  margin: 0 auto;
  -moz-box-shadow: 0px 5px 20px #ccc;
  -webkit-box-shadow: 0px 5px 20px #ccc;
  box-shadow: 0px 5px 20px #ccc;
}
#map.large{
  height:500px;
}

</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Reporte Trámites en Procesos
        <small> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="#">Reporte</a></li>
        <li class="active">Usuarios</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <!-- Inicia contenido -->
            <div class="box">
                <!--        <div class="box-body">-->
                <div class="col-xl-12">
                    <fieldset class="yellow-fieldset">
                        <legend style="text-align:center;">Filtros</legend>
                        <div class="row form-group" >
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <input type="hidden" id="area_id" name="area_id">
                                    <label class="control-label">Area:</label>
                                    <select class="form-control" name="slct_area_id[]" id="slct_area_id" multiple>
                                    </select>
                                </div>
                                <div class="col-md-2" hidden="">
                                    <label class="control-label">¿Desea mostrar Área?</label>
                                    <select class="form-control" name="slct_sino" id="slct_sino" class="form-control">
                                        <option value="0" >NO</option>
                                        <option value="1" selected="">SI</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label">Fechas Inicio:</label>
                                    <input type="text" class="form-control fechas" placeholder="AAAA-MM-DD" id="fecha_ini" name="fecha_ini"/>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label">Fechas Fin:</label>
                                    <input type="text" class="form-control fechas" placeholder="AAAA-MM-DD" id="fecha_fin" name="fecha_fin" />
                                </div>
                                <br>
                                <input type="button" class="btn btn-info" id="generar" name="generar" value="Calcular">

                                <a class='btn btn-success' id="btnexport" name="btnexport"><i class="glyphicon glyphicon-download-alt">Exportar</i></a>

                            </div>
                        </div>
                    </fieldset> 
                </div>
                <!--            <div class="row form-group" id="reporte" >-->
                <div class="col-xl-12">
                    <br>
                    <div class="box-body table-responsive">
                        <table id="t_proceso" class="table table-bordered">
                            <thead id="tt_proceso">
                                <tr>
                                    <th>Procesos</th>
                                </tr>
                            </thead>
                            <tbody id="tb_proceso">
                            </tbody>
                        </table>
                    </div>

                    <!--                    <div class="box-body table-responsive">
                                            <table id="t_resumen" class="table table-bordered">
                                                <thead id="tt_resumen">
                                                </thead>
                                                <tbody id="tb_resumen">
                                                </tbody>
                                            </table>
                                        </div>-->

                </div>
                <br>
                <div class="col-xl-12">
                    <style>
                        .foto_desmonte {
                            overflow:hidden;
                            border: 2px solid #3c8dbc40;
                            background:#fefefe;
                            -moz-border-radius:5px;
                            -webkit-border-radius:5px;
                            border-radius: 10px;
                            -moz-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
                            -webkit-box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
                        }
                    </style>
                    <div id="div_ver_archivos_id" class=""></div>
                    <div id="div_ver_mapas_id" class=""></div>
                    <div id="div_ver_orden_trabajo" class=""></div>
                    <!-- <form id="form_1" name="form_1"></form> -->
                    <div id="div_tactividad_previo" class="text-center"  style="display: none"></div>
                    <form id="form_tactividad" name="form_tactividad" method="POST" action="" style="display: none">
                        <div class="box-body table-responsive">
                            <table class="tree table table-bordered" id="t_resumen_tree">
                                <thead id="tt_resumen_tree">
                                    <tr>
                                        <th colspan="4" id="text_fecha_ini" style="text-align: right;"></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Resumen Global de todo el proceso</th>
                                    </tr>                                    
                                    <tr>
                                        <th>Trámites que Llegaron</th>
                                        <th>T. Pendientes / T. Pendientes a Destiempo</th>
                                        <th>Trámites Atendidos</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_resumen_tree">
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="box-body table-responsive">
                            <table class="tree table table-bordered" id="t_tree">
                                <thead id="tt_tree">
                                    <tr>
<!--                                        <th>N°</th>-->
                                        <th>Actividad</th>
                                        <th>Área</th>
                                        <th>Llegó</th>
                                        <th>Pendiente</th>
                                        <th>Atendido</th>
                                        <th>Finalizado</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_tree">
                                </tbody>
                            </table>
                        </div> 
                        <br>
                        <div class="box-body table-responsive" style="overflow: auto; width: 100%;">
                            <table id="t_tramite_actividad" class="table table-bordered no-footer dataTable">
                                <thead id="tt_tramite_actividad">
                                    <tr>
                                        <th>&nbsp</th>
                                        <th>&nbsp</th>
                                        <th>&nbsp</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_tramite_actividad">
                                </tbody>
                            </table>
                        </div>
                        <br>
                    </form>
                    <!--                    <br/>
                                        <div class="box-body table-responsive">
                                            <table id="t_orden_resumen" class="table table-bordered">
                                                <thead id="tt_orden_resum">
                                                </thead>
                                                <tbody id="tb_orden_resum">
                                                </tbody>
                                            </table>
                                        </div>-->
                    <!--                    <br/>-->
                    <!--                    <div class="box-body table-responsive">
                                            <table id="t_actividad_resumen" class="table table-bordered">
                                                <thead id="tt_actividad_resum">
                                                </thead>
                                                <tbody id="tb_actividad_resum">
                                                </tbody>
                                            </table>
                                        </div>-->
                </div>

                <div class="col-xl-12">
                    <form name="form_ruta_flujo" id="form_ruta_flujo" method="POST" action="" style="display: none;">
                        <div class="row form-group" >
                            <div class="col-sm-12">
                                <h1><span id="txt_titulo">Nueva Ruta</span>
                                    <small>
                                        <i class="fa fa-angle-double-right fa-lg"></i>
                                        <span id="texto_fecha_creacion">Fecha Creación:</span>
                                        <span id="fecha_creacion"></span>
                                    </small>
                                </h1>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                    <label class="control-label">Dueño del Proceso:</label>
                                    <input class="form-control" type="text" id="txt_persona_1" name="txt_persona_1" readonly>
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Proceso:</label>
                                    <input class="form-control" type="text" id="txt_proceso_1" name="txt_proceso_1" readonly>
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label">Area del Dueño del Proceso:</label>
                                    <input class="form-control" type="text" id="txt_area_1" name="txt_area_1" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" >
                            <div class="col-sm-12">
                                <div class="box-body table-responsive">
                                    <table id="areasasignacion" class="table table-bordered" style="min-height:300px">
                                        <thead> 
                                            <tr class="head">
                                                <th style="width:250px !important;min-width: 200px !important;" >
                                                </th>
                                                <th class="eliminadetalleg" style="min-width:1000px !important;">[]</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="body">
                                                <td>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr><th colspan="2">
                                                                </th></tr>
                                                            <tr class="head">
                                                                <th>#</th>
                                                                <th>Area</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tb_rutaflujodetalleAreas">
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="head">
                                                <th>#</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
<!--                <div class="col-xl-12" >
                    <form id="form_detallecuadro" name="form_detallecuadro" method="POST" action="" style="display: none">
                        <div class="box-body table-responsive" style="overflow: auto; height: 388px; width: 100%;">
                            <table id="t_detallecuadro" class="table table-bordered no-footer dataTable">
                                <thead id="tt_detallecuadro">
                                    <tr>
                                        <th>Flujo</th>
                                        <th>Área</th>
                                        <th>N orden</th>
                                        <th>Total</th>
                                        <th>T. F.</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_detallecuadro">
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>-->

                <div class="col-xl-12">
                    <form id="form_1" name="form_1"></form>
                    <form id="form_tramite" name="form_tramite" method="POST" action="" style="display: none">
                        <!--
                            <div class="box-body table-responsive" style="overflow: auto; height: 388px; width: 100%;">                            
                                <table id="t_tramite" class="table table-bordered no-footer dataTable">
                                    <thead id="tt_tramite">
                                        <tr>
                                            <th colspan="4" style='background-color:#DEFAFA;text-align:center'>Referente Trámite</th>
                                            <th colspan="9" style='background-color:#FCD790;text-align:center'>Trámite</th>
                                        </tr>
                                        <tr>
                                            <th>Fecha de inicio</th>
                                            <th>Trámite</th>
                                            <th>Nombre del Administrado</th>
                                            <th>Sumilla</th>
                                            <th>Trámite</th>
                                            <th>Tipo Sol</th>
                                            <th>Nombre del Administrado</th>
                                            <th>Asunto</th>
                                            <th>Estado</th>
                                            <th>Paso a la fecha</th>
                                            <th>Fecha Inicio</th>
                                            <th>Total de pasos</th>
                                            <th>[]</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb_tramite">
                                    </tbody>
                                </table>
                            </div>
                        -->
                    </form>
                </div>

                <hr>
                <div class="col-xl-12">
                    <div class="form-group" id="form_tramite_detalle" style="display: none">
                        <table id="t_reported_tab_1" class="table table-bordered" width="100%" >
                            <thead>
                                <tr>
                                    <th colspan="6" style='background-color:#DEFAFA; width: 30% !important;'>Datos del paso</th>
                                    <th style='background-color:#F5DF9D; width: 35% !important;'>Acciones a realizar</th>
                                    <th style='background-color:#FCD790; width: 35% !important;'>Acciones realizadas</th>
                                </tr>
                                <tr>
                                    <th style='background-color:#DEFAFA'>N°</th>
                                    <th style='background-color:#DEFAFA'>Área</th>
                                    <th style='background-color:#DEFAFA'>Tiempo</th>
                                    <th style='background-color:#DEFAFA'>Inicio</th>
                                    <th style='background-color:#DEFAFA'>Final</th>
                                    <th style='background-color:#DEFAFA'>Estado final</th>

                                    <th style='background-color:#F5DF9D'>Rol "tiene que"
                                        Accion
                                        Tipo Doc.
                                        (Descripcion)
                                    </th>

                                    <th style='background-color:#FCD790'>Estado
                                        (N° Doc.
                                        Descripcion)
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--            </div>-->

                <!--        </div> /.box -->

                <!-- Finaliza contenido -->
            </div>
        </div>
    </div>
</section><!-- /.content -->


@stop
@section('formulario')
@include( 'admin.produccion.form.actividades' )
@include( 'admin.ruta.form.ruta' )
@include( 'admin.reporte.form.grafica' )
@stop
