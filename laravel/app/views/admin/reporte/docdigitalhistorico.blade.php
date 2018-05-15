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
@include( 'admin.reporte.js.docdigitalhistorico_ajax' )
@include( 'admin.reporte.js.docdigitalhistorico' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        REPORTE DOCUMENTOS DIGITALES HISTÓRICO
        <small> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="#">Reporte</a></li>
        <li class="active">Histórico</li>
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
                    <div class="col-sm-4">
                        <label class="control-label">Título de Documento:</label>
                        <input type="text" class="form-control"  id="txt_titulo" name="txt_titulo"/>
                    </div>
                    <div class="col-sm-1" style="padding:24px">
                        <span class="btn btn-primary btn-md" id="generar" name="generar"><i class="glyphicon glyphicon-search"></i> Buscar</span>
                        {{-- <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="mostrar"> --}}
                    </div>
                    <div class="col-sm-1" style="padding:24px">
                        {{-- <span class="btn btn-success btn-md" id="btnexport" name="btnexport"><i class="glyphicon glyphicon-download-alt"></i> Export</span> --}}
                        <!--<a class='btn btn-success btn-md' id="btnexport" name="btnexport" href='' target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Export</i></a>-->
                        {{-- <input type="button" class="form-control btn btn-primary" id="generar" name="generar" value="mostrar"> --}}
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="box-body table-responsive">
            <div class="row form-group" id="reporte" style="display:none;">
                <div class="col-sm-12">
                    <div class="box-body table-responsive">
                        <table id="t_reporte" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Título</th>
                                    <th>Versión Final</th>
                                    <th>Histórico</th>
                                </tr>
                            </thead>
                            <tbody id="tb_reporte">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div><!-- /.box -->
    </div><!-- /.box -->

    <!-- Finaliza contenido -->
</div>
</section><!-- /.content -->
@stop
@section('formulario')
     @include( 'admin.reporte.form.dochistorico' )
@stop
