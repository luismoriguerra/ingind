<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    {{ HTML::style('lib/datepicker.css') }}
    {{ HTML::script('lib/bootstrap-datepicker.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.produccion.js.alertasactividad_ajax' )
    @include( 'admin.produccion.js.alertasactividad' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Alertas Actividad
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Alertas Actividad</li>
        </ol>

        <style type="text/css">
            .btn-yellow{
                color: #0070ba;
                background-color: ghostwhite;
                border-color: #ccc;
                font-weight: bold;
            }
        </style>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <div class="box">
                <fieldset>
                    <div class="row form-group" >
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <label class="control-label">Area:</label>
                                <select class="form-control" name="slct_area_id[]" id="slct_area_id" multiple>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label"></label>
                                <input type="button" class="form-control btn btn-primary" id="generar_area" name="generar_area" value="Mostrar">
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label"></label>
                                <span id="i_area"  data-estado="0" class="form-control btn btn-danger">Actividad</span>
                            </div>
                            <div class="col-sm-2">
                                <label class="control-label"></label>
                               <span id="a_area" data-estado="1" class="form-control btn btn-success">Actividad</span>
                            </div>
                        </div>
                    </div>
                </fieldset>
            <div class="box-body table-responsive">
                <form id="form_actividad" name="form_actividad"></form>
                <div class="row form-group" id="reporte" >
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_reporte" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Paterno</th>
                                        <th style="width: 20%">Materno</th>
                                        <th style="width: 20%">Nombre</th>
                                        <th style="width: 10%">Dni</th>
                                         <th style="width: 5%">Exoneracion</th>
{{--                                         <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th> --}}
                                        <th style="width: 5%">[]</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_reporte">
                                </tbody>
                                <tfoot>
                                </tfoot>
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
     @include( 'admin.reporte.form.produccionusu' )
     @include( 'admin.produccion.form.fechas_exoneradas' )
@stop
