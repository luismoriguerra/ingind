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
    @include( 'admin.reporte.js.auditoriaacceso_ajax' )
    @include( 'admin.reporte.js.auditoriaacceso' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reporte de Auditoría de Gerentes y Sub Gerentes
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Auditoría</li>
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
                                                <label class="control-label">Rango de Fechas:</label>
                                                <input type="text" class="form-control" placeholder="AAAA-MM-DD - AAAA-MM-DD" id="fecha" name="fecha" onfocus="blur()"/>
                            </div>
                             <div class="col-sm-3">
                                             <div class="col-sm-6">                            
                                                <label class="control-label" style="color: white">aaaaa</label>
                                                <input type="button" class="btn btn-info" id="generar" name="generar" value="Productividad">
                                             </div>
<!--                                            <div class="col-sm-6" >
                                                <label class="control-label" style="color: white">aaaaa</label>
                                                <a class='btn btn-success' id="btnexport" name="btnexport"><i class="glyphicon glyphicon-download-alt">Exportar</i></a>
                                            </div>-->
                                </div>
                        </div>
                    </div>
                </fieldset>
            
               <div class="box-body">
                <div class="row form-group" id="reporte" >
                    <div class="col-sm-12">
                        <div class="box-body table-responsive">
                            <table id="t_auditoria" class="table table-bordered">
                                <thead id="tt_auditoria">
                                    <tr>
                                        <th>Cuadro de Auditoría</th>
                                    </tr>
                                </thead>
                                <tbody id="tb_auditoria">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div><!-- /.box -->
            <canvas id="myChart" style="display: block; width: 200px;" ></canvas>
            <!-- Finaliza contenido -->
        </div>
    </section><!-- /.content -->
    

@stop
@section('formulario')
     @include( 'admin.reporte.form.auditoriaacceso' )
@stop
