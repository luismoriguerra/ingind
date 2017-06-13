<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
@parent

{{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
{{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

{{ Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
{{ Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js') }}

@include( 'admin.js.slct_global_ajax' )
@include( 'admin.js.slct_global' )
@include( 'admin.reporte.js.reporteproceso_ajax' )
@include( 'admin.reporte.js.reporteproceso' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
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
    <!-- Inicia contenido -->
    <div class="box">
        <fieldset>
            <div class="row form-group" >
                <div class="col-md-12">
                    <div class="col-md-4">
                        <input type="hidden" id="area_id" name="area_id">
                        <label class="control-label">Area:</label>
                        <select class="form-control" name="slct_area_id[]" id="slct_area_id" multiple>
                        </select>
                    </div>
                    <div class="col-md-3" style="display: none">
                        <label class="control-label">¿Desea mostrar Área?</label>
                        <select class="form-control" name="slct_sino" id="slct_sino" class="form-control">
                            <option value="0" selected="">NO</option>
                            <option value="1">SI</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="control-label">Fechas Inicio:</label>
                        <input type="text" class="form-control fechas" placeholder="AAAA-MM" id="fecha_ini" name="fecha_ini"/>
                    </div>
                    <div class="col-md-2">
                        <label class="control-label">Fechas Fin:</label>
                        <input type="text" class="form-control fechas" placeholder="AAAA-MM" id="fecha_fin" name="fecha_fin" />
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-6">                            
                            <label class="control-label" style="color: white">aaaaa</label>
                            <input type="button" class="btn btn-info" id="generar" name="generar" value="Calcular">
                        </div>
                        <div class="col-md-6" >
                            <label class="control-label" style="color: white">aaaaa</label>
                            <a class='btn btn-success' id="btnexport" name="btnexport"><i class="glyphicon glyphicon-download-alt">Exportar</i></a>
                    </div>
                </div>
            </div>
            </div>
        </fieldset>

        <div class="box-body">
            <div class="row form-group" id="reporte" >
                <div class="col-sm-12">
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
                    
                    <div class="box-body table-responsive">
                        <table id="t_resumen" class="table table-bordered">
                            <thead id="tt_resumen">
                            </thead>
                            <tbody id="tb_resumen">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div><!-- /.box -->

        <!-- Finaliza contenido -->
    </div>
</section><!-- /.content -->


@stop
@section('formulario')
@include( 'admin.produccion.form.actividades' )
@stop
