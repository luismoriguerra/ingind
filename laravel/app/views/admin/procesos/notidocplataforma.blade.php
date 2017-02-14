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
    @include( 'admin.procesos.js.notidocplataforma_ajax' )
    @include( 'admin.procesos.js.notidocplataforma' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h3>
            NOTIFICACIONES DE LOS TRÁMITES INGRESADOS POR PLATAFORMA HACIA EL FLUJO DE PROCESOS
            <small> </small>
        </h3>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Documentos Generados</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <div class="box">
                <fieldset>
                    <div class="row form-group" >
<!--                        <div class="col-sm-4">
                           {{--  <div class="col-sm-5"> --}}
                                <label class="control-label">Rango de Fechas:</label>
                                <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                           {{--  </div> --}}
                        </div>
                        <div class="col-sm-4">
                        {{--     <div class="col-sm-5"> --}}
                                <label class="control-label">Área:</label>
                                <select class="form-control" name="slct_area_id" id="slct_area_id" multiple>
                                </select>
                           {{--  </div> --}}
                        </div>-->
                        <div class="col-sm-2">
                            <label class="control-label"></label>
                            <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="Mostrar">
                        </div>
<!--                        <div class="col-md-1 col-sm-2" style="padding:24px">
                            <a class='btn btn-success btn-md' id="btnexport" name="btnexport"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>
                        </div>-->
                    </div>
                </fieldset>
            </div><!-- /.box -->
            <div class="box-body table-responsive">
                <div class="row form-group" id="reporte" style="display:none;">
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_reporte" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="4" style="text-align:center;background-color: #DDEBF7 !important;">PROCESOS DE PLATAFORMA A LAS AREAS</th>
                                        <th colspan="6" style="text-align:center;background-color: #FFF2CC !important;">PROCESOS HACIA DONDE FUERON ASIGNADOS LOS TRÁMITES</th>
                                    </tr>
                                    <tr>
                                        <th style="background-color: #DDEBF7 !important;">Proceso</th>
                                        <th style="background-color: #DDEBF7 !important;">Trámite</th>
                                        <th style="background-color: #DDEBF7 !important;">Fecha Inicio<br> Trámite</th>
                                        <th style="background-color: #DDEBF7 !important;">Fecha Final<br> Trámite</th>
                                        <th style="background-color: #FFF2CC !important;">Proceso</th>
                                        <th style="background-color: #FFF2CC !important;">Fecha Inicio<br> en el Proceso</th>
                                        <th style="background-color: #FFF2CC !important;">Total N°<br> de Pasos</th>
                                        <th style="background-color: #FFF2CC !important;">Paso<br> Actual</th>
                                        <th style="background-color: #FFF2CC !important;">Fecha límite en el paso</th>
                                        <th style="background-color: #FFF2CC !important;">Fecha final del trámite en el proceso</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_reporte">
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
