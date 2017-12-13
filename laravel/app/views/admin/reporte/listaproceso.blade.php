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
@include( 'admin.reporte.js.listaproceso' )


@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<!-- Content Header (Page header) -->
<style>
.modal { overflow: auto !important; 
</style>
<section class="content-header">
    <h1>
        Lista de  Proceso - Trámite
        <small> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="#">Ruta</a></li>
        <li class="active">Listado</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <!-- Inicia contenido -->
            <div class="box">      
                <form id="form_crear" name="form_crear" method="POST" action="">

                    <select style="display:none" class="form-control" name="slct_estados" id="slct_estados">
                        <option value>.::TODOS::.</option>
                        <option value="1">Producción</option>
                        <option value="2">Pendiente</option>
                    </select>
                    <input type="hidden" id="tipo_flujo" name="tipo_flujo" value="1">
                    <div class="box-body table-responsive">
                        <table id="t_crear" class="table table-bordered table-hover">


                            <thead>

                                <tr>

                                    <th colspan="5" style="text-align:center;background-color:#A7C0DC;"><h2> Lista de Procesos- Trámite</h2></th>

                                </tr>
                                <tr></tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr></tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                </form>
            </div><!-- /.box -->
            <!-- Finaliza contenido -->
        </div>
    </div>

</section><!-- /.content -->
@stop

@section('formulario')
@include( 'admin.ruta.form.rutaflujo' )
@include( 'admin.ruta.form.ruta' )
@stop
