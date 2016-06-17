<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.ruta.js.ruta_ajax' )
    @include( 'admin.reporte.js.estadocronogramatareas_ajax' )
    @include( 'admin.reporte.js.estadocronogramatareas' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')

<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Estado de Cronograma de Tareas
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Estado de Cronograma de Tareas</li>
        </ol>
    </section>

    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
         <div class="row">
                <div class="col-xs-12">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="box-header">
                        
                            <div class="col-sm-12">
                                <div class="col-sm-3">

                                    <label class="control-label">Semaforo:
                                    </label>
                                    <select class="form-control" name="slct_semaforo" id="slct_semaforo">
                                        <option value="">.::Seleccione::.</option>
                                        <option value="FE0000">ROJO - INCUMPLIMIENTO DEL PROCESO</option>
                                        <option value="F8BB00">AMBAR - SI EXISTE RETRASO EN EL PASO</option>
                                        <option value="75FF75">VERDE - NO EXISTE RETRASO EN EL PASO</option>
                                    </select>
                                    

                                </div>


                                <div class="col-sm-3">
                                    <label class="control-label">Tramite:
                                    </label>
                                    <input type="text" name="txt_tramite" id="txt_tramite" class="form-control" placeholder="Tipo + Nro + Año  => Ej: EX {{ rand(3000,9999) }} {{ date("Y") }}">
                                </div>

                                <div class="col-sm-3">
                                    <label class="control-label">Fecha:
                                    </label>
                                    <input type="text" name="txt_fecha" id="txt_fecha" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" onfocus="blur()">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-3">
                                    <label class="control-label">Categoria:</label>
                                    <select id="slct_categoria" name="slct_categoria" class="form-control"></select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">Área:</label>
                                    <select id="slct_area" name="slct_area" class="form-control"></select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">
                                    </label>
                                    <input type="button" class="form-control btn btn-primary" id="mostrar" name="mostrar" value="Mostrar">
                                </div>
                            </div>

                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <table id="t_reporte" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='background-color:#FFF2CC; TEXT-ALIGN: center; ' colspan="5">PROCESO</th>
                                        <th style='background-color:#DEEBF7; TEXT-ALIGN: center; ' colspan="6">TRAMITE</th>
                                        <th style='background-color:#C4DFB3; TEXT-ALIGN: center; ' colspan="5">TAREA Y RESPONSABLE</th>
                                    </tr>
                                    <tr>
                                        <th style='background-color:#FFF2CC'>PROCESO</th>
                                        <th style='background-color:#FFF2CC'>N° DE PASOS</th>
                                        <th style='background-color:#FFF2CC'>DIAS TOTAL</th>
                                        <th style='background-color:#FFF2CC'>F. INICIO<BR>CRONOGRAMA</th>
                                        <th style='background-color:#FFF2CC'>F. FINA<BR>CRONOGRAMA</th>
                                        <th style='background-color:#DEEBF7'>TRAMITE</th>
                                        <th style='background-color:#DEEBF7'>PASO ACTUAL</th>
                                        <th style='background-color:#DEEBF7'>DIAS</th>
                                        <th style='background-color:#DEEBF7'>F INICIO</th>
                                        <th style='background-color:#DEEBF7'>F FINAL</th>
                                        <th style='background-color:#DEEBF7'>SEMAFORO</th>
                                        <th style='background-color:#C4DFB3'>TIPO TAREA</th>
                                        <th style='background-color:#C4DFB3'>DESCRIPCION TAREA</th>
                                        <th style='background-color:#C4DFB3'>AREA</th>
                                        <th style='background-color:#C4DFB3'>RESPONSABLE</th>
                                        <th style='background-color:#C4DFB3'>RECURSO</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_reporte">
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>
    </section><!-- /.content -->

@stop
@section('formulario')
     @include( 'admin.ruta.form.ruta' )
@stop
