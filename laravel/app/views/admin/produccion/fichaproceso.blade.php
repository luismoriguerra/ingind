<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
@parent
{{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
{{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}

{{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
{{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

{{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
{{ HTML::script('lib/momentjs/2.9.0/moment.min.js') }} 
{{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}

@include( 'admin.js.slct_global_ajax' )
@include( 'admin.js.slct_global' )
@include( 'admin.produccion.js.fichaproceso_ajax' )
@include( 'admin.produccion.js.fichaproceso' )
@include( 'admin.ruta.js.ruta_ajax' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<!-- Main content -->
<style>
.modal { overflow: auto !important; 
</style>
<section class="content-header">
    <h1>
        Ficha Proceso
        <small> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="#">Proceso</a></li>
        <li class="active">Ficha Proceso</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <!-- Inicia contenido -->
            <div class="box">
                <div class="row">
                    <!-- Inicia contenido -->
                    <div class="col-md-12">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label class="control-label">Entidad:</label>
                                <input type="text" class="form-control mant" name="txt_entidad" id="txt_entidad" value="MUNICIPALIDAD DISTRITAL DE INDEPENDENCIA" disabled="disabled" style="text-align: center">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Fecha:</label>
                                <input type="text" class="form-control mant" name="txt_fecha" id="txt_fecha" value="" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Usuario:</label>
                                <input type="text" name="txt_userresponsable" id="txt_userresponsable" class="form-control mant"  readonly="">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class='form-control mant' type="hidden" name="slct_area_p_id" id="slct_area_p_id" value="<?php echo Auth::user()->area_id; ?>">
                                <label class="control-label"> Area:</label>
                                <input class='form-control' id='nombre_area_usuario' name='nombre_area_usuario' value='<?php echo Auth::user()->areas->nombre; ?>' readOnly=''>
                            </div>
                        </div>
                    </div>
                    <form id="form_ficha" name="form_ficha" method="POST" action="">
                        <div class="col-md-12">
                            <div class="box-body">
    <!--                            <form id="form_ficha" name="form_ficha" method="POST" action="">-->
                                    <input type="hidden" id="ficha_proceso_id" name="ficha_proceso_id">
                                    <input type="hidden" id="ficha_proceso_respuesta_id" name="ficha_proceso_respuesta_id">
                                    <div class="row form-group">
                                        <div class="col-sm-12">
                                            <table id="t_ficha" class="table table-striped" >
                                                <thead>
                                                    <tr>
                                                    
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_ficha">
                                                </tbody>                             
                                            </table>
                                        </div>
                                    </div>
    <!--                            </form>-->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary pull-right" onclick="registrarFicha()">Guardar</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="box-body table-responsive">
    <!--                            <form id="form_proceso" name="form_proceso" method="POST" action="">-->
                                    <div class="row form-group">
                                        <div class="col-sm-12"><h3 style="text-align:center; "><b>SELECCIONE LOS PROCESOS VALIDADOS POR SU ÁREA: </b></h3>
                                            <table id="t_proceso" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>[]</th>
                                                        <th>Proceso</th>
                                                        <th>[]</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_proceso">
                                                </tbody>                             
                                            </table>
                                        </div>
                                    </div>
    <!--                            </form>-->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary pull-right" onclick="registrarFicha()">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>    
                </div>
            </div><!-- /.col (RIGHT) -->
        </div>
        <!-- Finaliza contenido -->
    </div>
</section><!-- /.content -->
@stop
@section('formulario')
@include( 'admin.inventario.form.confirmacion' )
@include( 'admin.ruta.form.rutaflujo' )
@include( 'admin.ruta.form.ruta' )
@stop