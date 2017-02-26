<!DOCTYPE html>
@extends('layouts.master')

@section('includes')
    @parent

    {{ HTML::style('lib/daterangepicker/css/daterangepicker-bs3.css') }}

    {{ HTML::style('lib/bootstrap-multiselect/dist/css/bootstrap-multiselect.css') }}

    {{ HTML::script('//cdn.jsdelivr.net/momentjs/2.9.0/moment.min.js') }}
    {{ HTML::script('lib/daterangepicker/js/daterangepicker_single.js') }}

    
    {{ HTML::script('lib/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}
    @include( 'admin.js.slct_global_ajax' )
    @include( 'admin.js.slct_global' )
    
    @include( 'admin.ruta.js.indedocs' )
    @include( 'admin.ruta.js.indedocs_ajax' )
    
    @include( 'admin.reporte.js.docdigasignado_ajax' )
    @include( 'admin.reporte.js.docdigasignado' )
@stop
<!-- Right side column. Contains the navbar and content of the page -->
@section('contenido')
    <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Documentos Digitales
                <small> </small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
                <li><a href="#">Mantenimientos</a></li>
                <li class="active">Editar Asignacion</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Inicia contenido -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Filtros</h3>
                            <div class="row form-group" >
                                <div class="col-sm-12">
                                    <div class="col-sm-4">
                                        <label class="control-label">Seleccione Tipo:</label>
                                        <select class="form-control" name="slct_docdig" id="slct_docdig">
                                            <option value="">Seleccione Tipo</option>
                                            <option value="0">No Asignados</option>
                                            <option value="1">Asignados</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-header -->
                        <form id="form_documentos" name="form_documentos" method="POST" action="">
                        <input type="hidden" name="txt_idtipo" id="txt_idtipo">
                        <div class="box-body table-responsive">
                            <table id="t_documentos" class="table table-bordered table-hover">
                                <thead>
                                <tr><th colspan="4" style="text-align:center;background-color:#A7C0DC;"><h2> Documentos Digitales</h2></th></tr>
                                <tr></tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr></tr>
                                </tfoot>
                            </table>
                          {{--   <a class="btn btn-primary"
                            data-toggle="modal" data-target="#documentoModal" data-titulo="Nuevo"><i class="fa fa-plus fa-lg"></i>&nbsp;Nuevo</a>
                            <a style="display:none" id="BtnEditar" data-toggle="modal" data-target="#documentoModal" data-titulo="Editar"></a> --}}
                        </div><!-- /.box-body -->
                        </form>
                    </div><!-- /.box -->
                    <!-- Finaliza contenido -->
                </div>
            </div>

        </section><!-- /.content -->
@stop

@section('formulario')
     @include( 'admin.ruta.form.editasignado' )
     @include( 'admin.ruta.form.indedocs' )
@stop
