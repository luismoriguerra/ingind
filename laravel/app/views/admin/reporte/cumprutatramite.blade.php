<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    {{ HTML::style('lib/bootstrap-fileinput/css/fileinput.min.css') }}
    {{ HTML::script('lib/bootstrap-fileinput/js/fileinput.min.js') }} 
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.reporte.js.cump_ruta_tramite' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Reporte de Cumplimiento de ruta por tramite
                        <small> </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                        <li><a href="#">Reporte</a></li>
                        <li class="active">Reporte de Cumplimiento de ruta por tramite</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    
                </section><!-- /.content -->
@stop

