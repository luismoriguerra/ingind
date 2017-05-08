<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent
    {{ HTML::script('lib/jquery-form/jquery-form.js') }} 
    {{ HTML::style('lib/fullcalendar-2.7/fullcalendar.css') }}
    {{ HTML::style('lib/fullcalendar-2.7/fullcalendar.print.css', array('media' => 'print')) }}
    {{ HTML::script('lib/fullcalendar-2.7/lib/moment.min.js') }}
    {{ HTML::script('lib/fullcalendar-2.7/fullcalendar.min.js') }}
    {{ HTML::script('lib/fullcalendar-2.7/lang/es.js') }}

    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.mantenimiento.js.fechanolaboral_ajax' )
    @include( 'admin.mantenimiento.js.fechanolaboral' )
@stop

@section('contenido')

    <section class="content-header">
        <h1>
            Mantenimiento de Fechas <b>No</b> laborales
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Mantenimientos</a></li>
            <li class="active">Mantenimiento de Fechas <b>No</b> laborales</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body no-padding">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('formulario')
     @include( 'admin.mantenimiento.form.fechanolaborable' )
@stop
