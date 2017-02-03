<!DOCTYPE html>
@extends('layouts.master')  

@section('includes')
    @parent
    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}

    {{ HTML::style('lib/datepicker.css') }}
    {{ HTML::script('lib/bootstrap-timepicker/js/bootstrap-timepicker.js') }}


    {{ HTML::style('lib/bootstrap-timepicker/compiled/timepicker.css') }}
    {{ HTML::script('lib/bootstrap-datepicker.js') }}

{{--     {{ HTML::script('//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }} --}}

    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    @include( 'admin.produccion.js.ordentrabajo_ajax' )
    @include( 'admin.produccion.js.ordentrabajo' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')

<style type="text/css">
    .btn-yellow{
        color: #0070ba;
        background-color: ghostwhite;
        border-color: #ccc;
        font-weight: bold;
    }

    .yellow-fieldset{
        max-width: 100% !important;
        border: 3px solid #999;
        padding:10px 20px 2px 20px;
        border-radius: 10px; 
    }

    .margin-top-10{
         margin-top: 10px;   
    }
</style>
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Crear Actividad Personal
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Actividad Personal</a></li>
                <li class="active">Crear</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="col-md-12 visible-lg visible-md filtros" style="margin-top:10px">
                            <div class="row">
                                <div class="col-md-1 col-xs-3 col-sm-3">
                                    <label>Total Hrs:</label>
                                </div>
                                <div class="col-md-3 col-xs-4 col-sm-4">
                                    <input type="text" class="form-control" id="txt_ttotal" name="txt_ttotal" readonly="readonly">                                            
                                </div>
                                <div class="col-md-3 col-xs-4 col-sm-4">
                                    <span class="btn btn-primary btn-success" id="btnGuardar" onclick="guardarTodo()">Guardar  <i class="glyphicon glyphicon-plus"></i></span>                                            
                                </div>
                                <div class="col-md-5 col-xs-5 col-sm-5 selectbyPerson hidden">
                                    <div class="col-md-4">
                                         <label>Seleccionar Personal:</label>
                                    </div>
                                    <div class="col-md-8">
                                       <select class="form-control" id="slct_personasA" name="slct_personasA">
                                           
                                       </select>                                                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 visible-sm visible-xs filtros" style="margin-top:10px;margin-bottom: 10px;">
                            <div class="row">
                                <div class="col-md-1 col-xs-3 col-sm-3">
                                    <label>Total Hrs:</label>
                                </div>
                                <div class="col-md-3 col-xs-4 col-sm-4">
                                    <input type="text" class="form-control" id="" name="" readonly="readonly">                                            
                                </div>
                                <div class="col-md-3 col-xs-4 col-sm-4">
                                    <span class="btn btn-primary btn-success" onclick="guardarTodo()">Guardar  <i class="glyphicon glyphicon-plus"></i></span>                                            
                                </div>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                        <br>
                            <div class="col-md-12">
                                <div class="ordenesT">
                                    <fieldset class="yellow-fieldset valido">
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label>Actividad:</label>
                                                <textarea class="form-control" id="txt_actividad" name="txt_actividad" rows="2"> </textarea>
                                               {{--  <input type="text" class="form-control" id="txt_actividad" name="txt_actividad"> --}}
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Fecha Inicio:</label>
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="datepicker form-control fechaInicio" id="txt_fechaInicio" name="txt_fechaInicio" onchange="fecha(this)">
                                                    </div>
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="timepicker form-control horaInicio" id="txt_horaInicio" name="txt_horaInicio" onchange="CalcularHrs(this)">
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Fecha Final:</label>
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="datepicker form-control fechaFin" id="txt_fechaFin" name="txt_fechaFin"  disabled="disabled">
                                                    </div>
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="timepicker form-control horaFin" id="txt_horaFin" name="txt_horaFin" onchange="CalcularHrs(this)">
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Tiempo Transcurrido:</label>
                                                <input type="text" class="form-control ttranscurrido" id="txt_ttranscurrido" name="txt_ttranscurrido" readonly="readonly">
                                            </div>                                                    
                                        </div>
                                    </fieldset>

                                    <fieldset class="yellow-fieldset template-orden margin-top-10 hidden">
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label>Actividad:</label>
                                                <textarea class="form-control" id="txt_actividad" name="txt_actividad" rows="2"></textarea>
                                               {{--  <input type="text" class="form-control" id="txt_actividad" name="txt_actividad"> --}}
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Fecha Inicio:</label>
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="datepicker form-control fechaInicio" id="txt_fechaInicio" name="txt_fechaInicio" onchange="fecha(this)">
                                                    </div>
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="timepicker form-control horaInicio" id="txt_horaInicio" name="txt_horaInicio" onchange="CalcularHrs(this)">
                                                    </div>                                                      
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label>Fecha Final:</label>
                                                <div class="row">
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="datepicker form-control fechaFin" id="txt_fechaFin" name="txt_fechaFin" disabled="disabled">
                                                    </div>
                                                    <div class="col-md-6 col-xs-6 col-sm-6">
                                                        <input type="text" class="timepicker form-control horaFin" id="txt_horaFin" name="txt_horaFin" onchange="CalcularHrs(this)">
                                                    </div>                                                      
                                                </div>
                                            </div>
                                            <div class="col-md-2 form-group">
                                                <label>Tiempo Transcurrido:</label>
                                                <input type="text" class="form-control ttranscurrido" id="txt_ttranscurrido" name="txt_ttranscurrido" readonly="readonly">
                                            </div>
                                            <div class="col-md-1 form-group visible-lg visible-md">
                                                <span id="btnDelete" name="btnDelete" class="btn btn-danger  btn-sm btnDelete" onclick="Deletetr(this)" style="margin-top: 36%;"><i class="glyphicon glyphicon-remove"></i></span>
                                            </div>
                                            <div class="col-md-1 col-sm-12 col-xs-12 form-group visible-sm visible-xs">
                                                <span id="btnDelete" name="btnDelete" class="btn btn-danger  btn-sm btnDelete" onclick="Deletetr(this)" style="width: 100%">Eliminar</span>
                                            </div>                                                            
                                        </div>
                                    </fieldset>
                                </div>
                                <button id="btnAdd" class="btn btn-yellow" style="width: 100%;margin-top:10px" type="button"><span class="glyphicon glyphicon-plus"></span> AGREGAR </button>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
{{--      @include( 'admin.mantenimiento.form.cargo' ) --}}
@stop
