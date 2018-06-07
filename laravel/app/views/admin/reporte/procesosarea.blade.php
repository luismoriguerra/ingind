<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent 
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    {{ Html::style('lib/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
    {{ Html::script('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}
    {{ Html::script('lib/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js') }}
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js') }}


    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.reporte.js.reporteprocesoarea_ajax' )
    @include( 'admin.reporte.js.reporteprocesoarea' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->

            <style type="text/css">
                    canvas{
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }


            </style>
    <section class="content-header">
        <h1>
            Cantidad de procesos generados por area
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Procesos por area</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <div class="box">
                <fieldset>
                    <form name="form_reporte" id="form_reporte">
                    <div class="row form-group" >
                        <div class="col-sm-12">
                            <div class="col-sm-4"><input type="hidden" id="area_id" name="area_id">
                                <label class="control-label">Area:</label>
                                <select class="form-control" name="area_id[]" id="slct_area_id" multiple>
                                </select>
                            </div>
                             <div class="col-sm-2">
                                                <label class="control-label">Fecha inicial:</label>
                                                <input type="text" class="form-control fechaMes" placeholder="AAAA/MM" id="fecha0" name="fecha_ini" onfocus="blur()"/>
                            </div>
                             <div class="col-sm-2">
                                                <label class="control-label">Fecha final:</label>
                                                <input type="text" class="form-control fechaMes" placeholder="AAAA/MM" id="fecha1" name="fecha_fin" onfocus="blur()"/>
                            </div>
                             <div class="col-sm-3">
                                             <div class="col-sm-6">                            
                                                <label class="control-label" style="color: white">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                                <input type="button" class="btn btn-info" id="generar" name="generar" value="Generar Reporte">
                                             </div> 
                                </div>
<!--                            <div class="col-sm-2">
                                <label class="control-label"></label>
                                <input type="button" class="form-control btn btn-primary" id="generar_area" name="generar_area" value="Mostrar">
                            </div>-->
                        </div>
                    </div>
                </form>
                </fieldset>
            
               <div class="box-body">
                <div class="row form-group" id="reporte" >
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_produccion" class="table table-bordered">
                                <thead id="tt_produccion">
                                    <tr>
                                        <th>Cuadro de resultado</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_produccion">
                                </tbody>
                            </table>
                            <div clas="row">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-8">
                                <div style="width:100%;">
                                    <canvas id="canvas"></canvas>
                                </div></div>
                                <div class="col-md-2">&nbsp;</div>
                            </div>
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
