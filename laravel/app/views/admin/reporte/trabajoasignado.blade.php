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
    @include( 'admin.reporte.js.trabajoasignado_ajax' )
    @include( 'admin.reporte.js.trabajoasignado' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            TRABAJOS ASIGNADOS POR EQUIPOS O POR PARTICIPANTES
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Trabajos Asignados</li>
        </ol>
    </section>

        <!-- Main content -->
        <section class="content">
            <!-- Inicia contenido -->
            <div class="box">
                <fieldset>
                    <div class="row form-group" >
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <label class="control-label">Autoriza:</label>
                                <select class="form-control" name="slct_autoriza_id" id="slct_autoriza_id" multiple>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Miembros del Proyecto:</label>
                                <select class="form-control" name="slct_miembros_id" id="slct_miembros_id" multiple>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Procesos:</label>
                                <select class="form-control" name="slct_flujo_id" id="slct_flujo_id" multiple>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <label class="control-label">Responsable:</label>
                                <select class="form-control" name="slct_responsable_id" id="slct_responsable_id" multiple>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Carta Inicio:</label>
                                <input class="form-control" type="text" name="txt_carta_inicio" id="txt_carta_inicio">
                            </div>
                            <div class="col-sm-4">
                                <label class="control-label">Estado Proyecto:</label>
                                <select class="form-control" name="slct_estado_id" id="slct_estado_id" multiple>
                                <option value="Concluido">Concluidos</option>
                                <option value="Inconcluso">Inconclusos</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-4">
                                <label class="control-label">Objetivo Proyecto:</label>
                                <input class="form-control" type="text" name="txt_objetivo" id="txt_objetivo">
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">Fecha de Inicio:</label>
                                <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha"/>
                            </div>
                            <div class="col-sm-2">
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
                                        <th>NOMBRE DEL PROCESO DE OFICIO</th>
                                        <th>AUTORIZA EL PROYECTO</th>
                                        <th>AREA DEL QUE AUTORIZA</th>
                                        <th>RESPONSABLE  DEL PROYECTO</th>
                                        <th>ROL DEL RESPONSABLE</th>
                                        <th>CARTA DE INICIO</th>
                                        <th>OBJETIVO DEL PROYECTO</th>
                                        <th>MIEMBROS DEL PROYECTO</th>
                                        <th>FECHA DE INICIO PROGRAMADO</th>
                                        <th>FECHA FINAL PROGRAMADO</th>
                                        <th>ESTADO DEL PROYECTO</th>
                                        <!--th>FECHA FINAL EJECUTADO</th-->
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
