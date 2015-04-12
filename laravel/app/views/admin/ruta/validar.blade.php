<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    
    {{ HTML::script('lib/input-mask/js/jquery.inputmask.js') }}
    {{ HTML::script('lib/input-mask/js/jquery.inputmask.date.extensions.js') }}
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )

    @include( 'admin.ruta.js.validar_ajax' )
    @include( 'admin.ruta.js.validar' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Validar Ruta
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Ruta</a></li>
                        <li class="active">Validar</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- Inicia contenido -->
                            <div class="box">
                                <form name="form_validar" id="form_validar" method="POST" action="">
                                    <div class="row form-group" >
                                        <div class="col-sm-12">
                                            <div class="col-sm-3">
                                                <label class="control-label">Tipo Flujo:</label>
                                                <select class="form-control" name="slct_flujo_id" id="slct_flujo_id" onchange="mostrarRutaFlujo();">
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="control-label">Area:</label>
                                                <select class="form-control" name="slct_area_id" id="slct_area_id" onchange="mostrarRutaFlujo();">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group" id="tabla_ruta_detalle" style="display:none;">
                                        <div class="col-sm-12">
                                            <div class="box-body table-responsive">
                                                <table id="t_ruta_detalle" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Tipo Flujo</th>
                                                            <th>Area</th>
                                                            <th>ID Doc</th>
                                                            <th>Fecha Inicio</th>
                                                            <th>Orden</th>
                                                            <th>Verbo(s)</th>
                                                            <th> [ ] </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tb_ruta_detalle">
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Tipo Flujo</th>
                                                            <th>Area</th>
                                                            <th>ID Doc</th>
                                                            <th>Fecha Inicio</th>
                                                            <th>Orden</th>
                                                            <th>Verbo(s)</th>
                                                            <th> [ ] </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <!--div class="col-sm-12">
                                            <a class="btn btn-primary btn-sm" id="btn_guardar_todo">
                                                <i class="fa fa-save fa-lg"></i>&nbsp;Guardar
                                            </a>
                                        </div-->
                                    </div>
                                </form>
                            </div><!-- /.box -->
                            <!-- Finaliza contenido -->
                        </div>
                    </div>

                </section><!-- /.content -->
@stop
