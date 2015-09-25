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
    @include( 'admin.reporte.js.expediente_ajax' )
    @include( 'admin.reporte.js.expediente' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Documento Generado por Trámite
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Expediente Único</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <div class="box">
                <fieldset>
                    <div class="row form-group" >
                        <div class="col-sm-12">
                            <div class="col-sm-5">
                                <label class="control-label">Rango de Fechas:</label>
                                <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label"></label>
                                <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="Mostrar">
                            </div>
                        </div>
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
                                        <th>Tramite</th>
                                        <th>Tipo Sol.</th>
                                        <th>Solicitante</th>
                                        <th>Sumilla</th>
                                        <th>Estado</th>
                                        <th>Paso a la fecha</th>
                                        <th>Total de pasos</th>
                                        <th>Fecha Trámite</th>
                                        <th>Fecha Inicio</th>
                                        <th>Pasos Sin alertas</th>
                                        <th>Pasos Con alertas</th>
                                        <th>Pasos Alertas validadas</th>
                                        <th> [ ] </th>
                                    </tr>
                                </thead>
                                <tbody id="tb_reporte">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
            <div class="box-body table-responsive">
                <div class="row form-group" id="reporte2" style="display:none;">
                    <div class="col-sm-12">
                        <table id="t_reporte2" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>N° Trámite</th>
                                    <th>Tipo Sol.</th>
                                    <th>Área Dueño Proceso</th>
                                    <th>Proceso</th>
                                    <th>N° Areas/N° Pasos</th>
                                    <th>Área Generadora</th>
                                    <th>Tipo Documento</th>
                                    <th>N° Doc Generado</th>
                                </tr>
                            </thead>
                            <tbody id="tb_reporte2">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
@stop
